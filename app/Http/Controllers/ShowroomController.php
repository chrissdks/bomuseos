<?php

namespace App\Http\Controllers;

use App\Showroom;
use Illuminate\Http\Request;
use App\Museum;
use Illuminate\Support\Facades\Auth;
use App\Rules\alpha_space;
use App\Rules\alpha_num_space;

class ShowroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $museum = Museum::All();
        $showroom= Showroom::query()
        ->select('showrooms.id as id','showrooms.name as showroom','museums.name as museum')
        ->join('museums','museums.id','=','showrooms.museum_id')
       ->orderBy('museum_id', 'DESC')->paginate(10);

        return view('showrooms')->with(['museum' => $museum,'showroom'=>$showroom]);
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

            'name'=> ['required', new alpha_num_space],
            'museum'=> 'required',

        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'name.alpha_num_space'=> 'El campo debe contener solamente caracteres alfanumericos y espacios',
            'museum.required'=> 'Seleccione un museo',
        ]);

        $showroom = new Showroom();
        $showroom->name = strtoupper( $request->name);
        $showroom->museum_id = $request->museum;
        $showroom->createdBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $showroom->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $showroom->deletedBy   = '';


        if($showroom->save()){
            return back()->with('msj', 'Datos guardados');
        }
        else{
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Showroom  $showroom
     * @return \Illuminate\Http\Response
     */
    public function show(Showroom $showroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Showroom  $showroom
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $museums = Museum::all();
        $editshowroom = Showroom::query()
            -> where('id',$id)
            ->get();
        return view('showrooms')->with(['edit' => true, 'editshowroom' => $editshowroom,'museums'=>$museums]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Showroom  $showroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'name'=> ['required', new alpha_num_space],
            'museum'=> 'required',
            ''

        ],[
            'name.required'=> 'El campo esta vacio,un nombre es necesario',
            'name.alpha_num_space'=> 'Este campo solo acepta carateres alphabeticos y espacios',
            'museum.required'=> 'Seleccione un museo',
        ]);

        $showroom = Showroom::find($id);
        $showroom->name = strtoupper( $request->name);
        $showroom->museum_id = $request->museum;
        $showroom->updatedBy   = Auth::user()->name.' '.Auth::user()->last_name;
        $showroom->deletedBy   = '';

        if($showroom->save()){
            return redirect('showrooms')->with('msj', 'Datos Modificados');
        }
        else{
            return back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Showroom  $showroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Showroom $showroom)
    {
        //
    }
}
