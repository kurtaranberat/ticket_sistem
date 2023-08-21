<?php

namespace App\Http\Controllers\Cozen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CozumlerController extends Controller
{
    public function  index(){
        return view ('cozen.index');
    }
    public function coz(){
        return view('cozen.panel.index');
    }
}
