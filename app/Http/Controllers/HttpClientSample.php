<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request as Request;
use React\EventLoop\Factory as EventLoopReactFactory;
use React\HttpClient\Response;
use React\HttpClient\Client as ReactClient;


class HttpClientSample extends Controller
{
	private $requestData = [];
	
	public function httpClientRequest()
	{
		$loop = EventLoopReactFactory::create();
		$client = new ReactClient($loop);

		//Request One
		$request = $client->request('GET', 'http://www.mocky.io/v2/5aef96dd2f00006400739bd6');
		$request->on('response', function(Response $response){
			$requestIdentifier = 'req1';

			$response->on('data', function($chunk) use($requestIdentifier){
				//sleep(1);
				@$this->requestData[$requestIdentifier] .= $chunk;
			});	

			$response->on('end', function() use($requestIdentifier){
		        echo 'DONE 1';
		        print_r($this->requestData[$requestIdentifier]);
		        echo '<br><br><br>';
		    });

		});
		$request->end();

		//Request Two
		$request2 = $client->request('GET', 'http://www.mocky.io/v2/5aef96dd2f00006400739bd6');
		$request2->on('response', function(Response $response){
			$requestIdentifier = 'req2';

			$response->on('data', function($chunk) use($requestIdentifier){
				//sleep(3);
				@$this->requestData[$requestIdentifier] .= $chunk;
			});	

			$response->on('end', function() use($requestIdentifier){
		        echo 'DONE 2';
		        print_r($this->requestData[$requestIdentifier]);
		        echo '<br><br><br>';
		    });
		});

		$request2->end();

		$loop->run();

		//echo "<br> ------- <br>";
		echo "<pre>";
		print_r($this->requestData);
	}
}
