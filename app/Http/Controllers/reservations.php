<?php


namespace app\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use VWS;



class reservations extends Controller
{
    public function index()
    {
    
        $reservation = Reservation::all();
       

       
        return view('reservations')->with(['reservations' => $reservation]);
    }


    public function listAll(){

    }

    public function store(Request $request){

 $reservation = new Reservation();







$meta = $request->name.'
'.$request->name.'666\n';
$arr = explode("\n", $meta);

$qrcode = new BaconQrCodeGenerator;
$qrcode->format('png')->margin(0)->size(480)->backgroundColor(255,255,255)->generate($request->name.' say10',base_path() . '/public/marcadores/'.$request->name.'.png');
$body=['name' => $request->name,
        'width' => 50,
        'image'=> base_path() . '/public/marcadores/'.$request->name.'.png',
        'application_metadata'=>$arr];


$result= VWS::addTarget(['name' => $request->name, 
    'width' => 50, 
    'path' => base_path() . '/public/marcadores/'.$request->name.'.png',
    'metadata'=>$meta]);
       // $body=json_decode($result['body'],true);
   //dd($result);
        $body=json_decode($result['body'],true);
















        /* $imageName =$request->name .'.' .$request->file('marcador')->getClientOriginalExtension();


    $request->file('marcador')->move( base_path() . '/public/marcadores/', $imageName);*/

    

       
        $reservation->name = $request->name;
        $reservation->path= base_path() ."/public/marcadores/".$request->name;










        if($result['status'] == 201){

            if($reservation->save()){

                return back()->with('msj', 'Datos guardados');
            }

            else{
                return back()->with('errormsj','No Se guardaron los datos');
            }
        }
        else{

            return back()->with('errormsj',$body['result_code']);
        }















        /* if($reservation->save()){
            return back()->with('msj', 'Datos guardados');
        }
        else{
            return back();
        }*/
    }

    public function edit($id){
        $pet = Pet::all();

        $reservation = Reservation::all();
        $user= User::query()
            ->select('users.id as user_id','users.name as name','users.last_name as last_name')
            ->join('user_roles','user_roles.user_id','=','users.id')
            ->join('pets','pets.user_id','=','users.id')
            ->where('user_roles.role_id',4)
            ->orderby('users.name', 'asc')
            ->groupby('users.id')
            ->get();

        $allreservation = Reservation::query()
            ->join('users','users.id','=','reservations.user_id')
            ->join('pets','pets.id','=','reservations.pet_id')
            ->select('reservations.id as id','users.id as uid','users.name as uname','users.last_name as ulname', 'pets.name as pname', 'pets.id as pid','date','tipo_res')
            ->where('reservations.id', $id)
            ->orderby('users.id', 'asc')
            ->get();

            $userpid=Reservation::find($id);
            $idp=$userpid->user_id;
            $lpets=Pet::where('user_id',$idp)
                ->select('id as lpetid','name as lpetname')
                ->get();
        $salas = Room::all();
        $room_find=Room::find($userpid->sala_id);

            $step = $this->cambiar_hora_a_step($room_find->franja);
        $id_sala= $room_find->id;
        $sala_name = $room_find->name;
        return view('reservations')->with(['edit' => true,'reservations' => $reservation,'pets' => $pet,'users'=>$user,
            'allreservation'=>$allreservation,'lpets'=>$lpets,'rooms'=>$salas,'step'=>$step,
                    'sala_id'=>$id_sala,'sala_name'=>$sala_name]);
    }

    public function update(Request $request, $id)
    {

       $this->validate($request,[

            'user_id'=> 'required',
            'pet'=> 'required',
            'tipo_res'=>'required',
           'date'=>'required|date|after:'.\Carbon\Carbon::tomorrow()->setTime(7,59).'|before:'.\Carbon\Carbon::tomorrow()->addMonth(1)->setTime(7,59),
        ],[
            'user_id.required'=> 'Seleccione un Dueño',
            'pet.required'=> 'Seleccione una Mascota',
            'tipo_res.required'=>'Seleccione el tipo de reserva',
           'date.required'=>'Seleccione una fecha',
           'date.after'=>'La fecha debe estar en el futuro desde las 8 de la mañana',
           'date.before'=>'La fecha excedio el limite de reserva'
       ]);


        $reservation = Reservation::find($id);
        $reservation->user_id           = $request->user_id;
        $reservation->pet_id            = $request->pet;
        $superdate= $request->date;
        $datetime =Carbon::parse($superdate)->format('Y-m-d H:i');
        $reservation->date =$datetime;
        $reservation->sala_id = $request->sala_id;
        $reservation->pet_id            = $request->pet;
        $reservation->tipo_res          = $request->tipo_res;
        $reservation->createdBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $reservation->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $reservation->deletedBy   = '';

        if($reservation->save()){
            return redirect('reservations')->with('msj', 'Datos Modificados');
        }
        else{
            return back();
        }
    }



   public function destroy($id)
    {
        $reservation = Reservation::find($id);

       $reservation->deletedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        if($reservation->save()){
            Reservation::destroy($id);
            return redirect('reservations')->with('msj', 'Datos Eliminados');
        }
        else{
            return back();
        }
    }
    public function cambiar_hora_a_step($string){
        $date =  Carbon::parse($string);
        $ans = ($date->hour * 60 + $date->minute) * 60;

        return $ans;
    }
}









