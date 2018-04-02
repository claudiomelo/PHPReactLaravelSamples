<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request as Request;
use React\EventLoop\Factory;
use React\Stream\DuplexResourceStream;

class ReactStreamsSampleController extends Controller
{
	public function streamReadSampleSample()
	{
		//implement streamReadSample
	}	

	public function duplexResourceStreamSample(Request $request)
	{

		// Simple plaintext HTTP client example (for illustration purposes only).
		// This shows how a plaintext TCP/IP connection is established to then send an
		// application level protocol message (HTTP).
		// Real applications should use react/http-client instead!
		//
		// This simple example only accepts an optional host parameter to send the
		// request to.
		//
		// $ php examples/01-http.php
		// $ php examples/01-http.php reactphp.org
		//require __DIR__ . '/../vendor/autoload.php';
		$host = isset($argv[1]) ? $argv[1] : 'www.google.com';
		// connect to tcp://www.google.com:80 (blocking call!)
		// for illustration purposes only, should use react/http-client or react/socket instead!
		$resource = stream_socket_client('tcp://' . $host . ':80');
		if (!$resource) {
		    exit(1);
		}
		$loop = Factory::create();
		$stream = new DuplexResourceStream($resource, $loop);
		$stream->on('data', function ($chunk) {
		    echo $chunk;
		    sleep(13);
		});

		echo "<br>legal<br>";

		$stream->on('close', function () {
		    echo '[CLOSED]' . PHP_EOL;
		});

		$stream->write("GET / HTTP/1.0\r\nHost: $host\r\n\r\n");
		$loop->run();
	}
}
