<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request as Request;

class HomeController extends Controller
{
	public function home(Request $request){
		return view('welcome');
	}
}
