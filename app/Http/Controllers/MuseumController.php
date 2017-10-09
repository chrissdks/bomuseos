<?php

namespace App\Http\Controllers;

use App\Museum;
use App\Rules\alpha_num_space;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\alpha_space;
use Illuminate\Support\Facades\File;



class MuseumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $museum = Museum::paginate(10);


        return view('museums')->with(['museum' => $museum]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[

            'name'=> ['required', new alpha_space],
            'address'=> ['required', new alpha_num_space],
            'phone'=> 'numeric',
        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'name.alpha_space'=> 'El campo debe contener solamente caracteres alfabeticos y espacios',
            'address.required'=> 'El campo esta vacio,una direccion es necesaria',
            'phone.numeric'=> 'El campo debe contener solamente caracteres numericos'
        ]);

        $museum = new Museum();
        $museum->name = strtoupper( $request->name);
        $museum->address = strtoupper( $request->address);
        $museum->phone =  $request->phone;
        $museum->createdBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $museum->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $museum->deletedBy   = '';

        if($museum->save()){
            File::makeDirectory(base_path() . '/public/marcadores/'.$request->name,0775, true);
            return back()->with('msj', 'Datos guardados');

        }
        else{
            return back();
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Museum  $museum
     * @return \Illuminate\Http\Response
     */
    public function show(Museum $museum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Museum  $museum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editmuseum = Museum::query()
        -> where('id',$id)
        ->get();
        return view('museums')->with(['edit' => true, 'editmuseum' => $editmuseum]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Museum  $museum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request,[

            'name'=> 'required|alpha',
            'address'=> 'required',
            'phone'=> 'numeric',
        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'name.alpha_dash'=> 'El campo debe contener solamente caracteres alfabeticos',
            'address.required'=> 'El campo esta vacio,una direccion es necesaria',
            'phone.numeric'=> 'El campo debe contener solamente caracteres alfabeticos'
        ]);

        $museum =  Museum::find($id);
        $museum->name = strtoupper( $request->name);
        $museum->address = strtoupper( $request->address);
        $museum->phone =  $request->phone;
        $museum->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $museum->deletedBy   = '';
        if($museum->save()){
            return redirect('museums')->with('msj', 'Datos Modificados');
        }
        else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Museum  $museum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $museum = Museum::find($id);
        $museum->deletedBy   = strtoupper(Auth::user()->name.' '.Auth::user()->last_name);
        if($museum->save()){
            Museum::destroy($id);
            return redirect('museums')->with('msj', 'Dato eliminado');
        }
        else{
            return back();
        }
    }

}
