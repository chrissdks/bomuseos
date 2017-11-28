<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Museum;
use App\Showroom;
use App\Artifact;


class genController extends Controller{

    public function findShowroom(Request $request){
    	//$data=DB::table('showrooms')->select('id', 'name')->where('museum_id', $request->id)->get();
        $data= Showroom::query()->select('id', 'name')->where('museum_id', $request->id)->get();
    	return $data;

    }





}
