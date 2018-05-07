<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request as Request;

class NormalHttpClientSample extends Controller
{
	private $requestData = [];
	
	public function httpClientRequest(Request $request)
	{
		$amount = isset($request->amount) ? $request->amount : 10;

		for ($i=0; $i < $amount; $i++) { 
			// Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => 'http://www.mocky.io/v2/5aef96dd2f00006400739bd6',
			    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
			));
			// Send the request & save response to $resp
			$this->requestData['req'.$i] = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
		}	
		
		echo "<pre>";
		print_r($this->requestData);
	}
}
