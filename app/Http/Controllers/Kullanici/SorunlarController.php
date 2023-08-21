<?php

namespace App\Http\Controllers\Kullanici;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SorunlarController extends Controller
{
     public  function  index(){
         return view ('kullanici.index');
     }
     public  function  sor(){
         return view('kullanici.panel.index');
     }
}
