<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public  function  index(){
        return view ('admin.problem.index');
    }
}
