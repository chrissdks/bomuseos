<?php

namespace App\Http\Controllers;

use App\Artifact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Museum;
use App\Showroom;
use App\Rules\alpha_num_space;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use VWS;
use PDF;
class ArtifactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showroom = Showroom::All();
        $museum = Museum::All();
        $artifact= Artifact::query()
            ->select('artifacts.id as id','artifacts.name as artifact','showrooms.name as showroom','museums.name as museum')
            ->join('showrooms','showrooms.id','=','artifacts.showroom_id')
            ->join('museums','museums.id','=','showrooms.museum_id')
            ->orderBy('museum_id', 'DESC')->paginate(10);


        return view('artifacts')->with(['showroom' => $showroom,'artifact'=>$artifact,'museum'=>$museum]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request,[

            'name'=> ['required', new alpha_num_space],
            'museum'=> 'required',
            'showroom'=>'required',
            'type'=>'required',
           // 'description'=>'required',
            'video'=>'required',

        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'type.required'=> 'Se requiere elegir un tipo',
            'name.alpha_num_space'=> 'El campo debe contener solamente caracteres alfanumericos y espacios',
            'museum.required'=> 'Seleccione un museo',
            'video.required'=> 'Seleccione un video',
        ]);

        $artifact = new Artifact();
        $artifact->name = $request->name;
        $artifact->type_id = $request->type;
        $artifact->showroom_id = $request->showroom;
        $artifact->createdBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $artifact->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $artifact->deletedBy   = '';


        //Carpetas de la ruta del marcador

        $museumname = DB::table('museums')
            ->select('id')
            ->where('id',$request->museum)->first();
        $showroomname = DB::table('showrooms')
            ->select('id')
            ->where('id',$request->showroom)->first();


//GENERACION DE CODIGO QR
        $qrcode = new BaconQrCodeGenerator;
        $qrcode->format('png')->margin(0)->size(480)->backgroundColor(255,255,255)->generate($request->name.','.Hash::make($request->name).','.$request->type.','.$request->showroom,base_path() . '/marcadores/'.str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'_marker.png');




//marker path
        $artifact->marker_path = "http://".request()->server('SERVER_ADDR') .'/bomuseos/marcadores/'.str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'_marker.png';

//Path para la imagen
      /*  if($request->hasFile('image')) {
            $imageName = str_replace(' ', '_', $request->name) . '.' . $request->file('image')->getClientOriginalExtension();
            $artifact->image_path = base_path() . 'public/marcadores' . $museumname->name . '/' . $showroomname->name . '/' .$imageName;

            $request->file('image')->move(base_path() . '/public/marcadores/' . $museumname->name . '/' . $showroomname->name . '/', $imageName);
            $image_path=base_path() . 'public/marcadores' . $museumname->name . '/' . $showroomname->name . '/' . $imageName;
        }
        else{
            $artifact->image_path='';
            $image_path='';
        }
*/

        if($request->hasFile('video')) {

            $videoName =str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'.'. $request->file('video')->getClientOriginalExtension();
            $artifact->video_url ="http://".request()->server('SERVER_ADDR') . '/bomuseos/marcadores/'.$videoName;

            $request->file('video')->move(base_path() . '/marcadores/',$videoName);
           // dd(base_path());
            $video_url= base_path() . '/marcadores/'.$videoName;
            $metaurl="http://".request()->server('SERVER_ADDR').'/bomuseos/marcadores/'.$videoName;
        }
        else{
            $artifact->video_url='';
            $video_url='';
        }
        $pre_meta =[
            //'name' => $request->name,
            //'type' => $request->type,
            //'showroom'=>$request->showroom,
            //'museum'=>$request->museum,
            'video_path'=>$video_url,
           // 'image'=>$image_path

        ];

        $meta = json_encode($pre_meta);
//metadata


        //marcador con VWS
        $result= VWS::addTarget([
            'name' =>str_replace(' ', '_',  $request->name),
            'width' => 50,
            'path' => base_path() . '/marcadores/'.str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'_marker.png',
            'metadata'=>$metaurl]);
        $body=json_decode($result['body'],true);

        if($result['status'] == 201){


            $artifact->target_id= $body['target_id'];
            if($artifact->save()){

                return back()->with('msj', 'Datos guardados');
            }


            else{
                VWS::deleteTarget($body['target_id']);
                return back()->with('errormsj','No Se guardaron los datos');

            }
        }
        else{

            return back()->with('errormsj',$body['result_code']);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artifact  $artifact
     * @return \Illuminate\Http\Response
     */
    public function show(Artifact $artifact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Artifact  $artifact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $museums = Museum::All();


        $editartifact = Artifact::query()
            -> where('id',$id)
            ->get();
        $mymuseum= Showroom::query()
            ->select('museum_id')
            ->where('id',$editartifact->last()->showroom_id)
            ->get();

        $theshowrooms=Showroom::query()
            ->where('museum_id',$mymuseum->last()->museum_id)
            ->get();


        return view('artifacts')->with(['edit' => true, 'editartifact' => $editartifact,'museum'=>$museums,'mymuseum'=>$mymuseum,'theshowrooms'=>$theshowrooms]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Artifact  $artifact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'name'=> ['required', new alpha_num_space],
            'museum'=> 'required',
            'showroom'=>'required',
            'type'=>'required',
            // 'description'=>'required',

        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'type.required'=> 'Se requiere elegir un tipo',
            'name.alpha_num_space'=> 'El campo debe contener solamente caracteres alfanumericos y espacios',
            'museum.required'=> 'Seleccione un museo',
        ]);




        $artifact = Artifact::find($id);

        $lastmuseum = DB::table('showrooms')
            ->select('museum_id')
            ->where('id',$artifact->showroom_id)->first();

        $museumname = DB::table('museums')
            ->select('id')
            ->where('id',$request->museum)->first();
        $showroomname = DB::table('showrooms')
            ->select('id')
            ->where('id',$request->showroom)->first();
        File::move( base_path() . '/marcadores/'.str_replace(' ', '_', $artifact->name).'_'.$lastmuseum->museum_id.'_'.$artifact->showroom_id.'_marker.png',base_path() . '/marcadores/'.str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'_marker.png');



        $extension = File::extension(str_replace(' ', '_', $artifact->name).'_'.$lastmuseum->museum_id.'_'.$artifact->showroom_id);



        //marker path
        $artifact->marker_path = base_path() .'/marcadores/'.str_replace(' ', '_', $request->name).'_'.$museumname->id.'_'.$request->showroom.'_marker.png';

        if($request->hasFile('video')) {
            $videoName =str_replace(' ', '_', $artifact->name).'_'.$lastmuseum->museum_id.'_'.$artifact->showroom_id.'.'.$request->file('video')->getClientOriginalExtension();

            $artifact->video_url = base_path() . '/marcadores/'.$videoName;



            $request->file('video')->move(base_path() . '/marcadores/',$videoName);
        }


        $artifact->name = $request->name;
        $artifact->type_id = $request->type;
        $artifact->showroom_id = $request->showroom;
        $artifact->createdBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $artifact->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $artifact->deletedBy   = '';

        if($artifact->save()){

            return redirect('artifacts')->with('msj', 'Datos Modificados');
        }


        else{
           return back()->with('errormsj','No Se guardaron los datos');

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artifact  $artifact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artefact = Artifact::find($id);
        $artefact->deletedBy   = (Auth::user()->name.' '.Auth::user()->last_name);
        VWS::deleteTarget($artefact->target_id);

        if($artefact->save()){
            Artifact::destroy($id);
            return redirect('artifacts')->with('msj', 'Dato eliminado');
        }
        else{
            return back();
        }
    }

    public function print_marker($id)
    {
        $marker = Artifact::find($id);

        $pdf = PDF::loadView('pdf',compact('marker'));
        return $pdf->stream($marker->name.'_'.$marker->type_id.'.pdf');
    }
}
