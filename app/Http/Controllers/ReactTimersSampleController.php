<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request as Request;
use React\EventLoop\Timer\TimerInterface;

class ReactTimersSampleController extends Controller
{

	/**
    * Simple addTimer Sample
    * @param Request $request - Request data (not used here)
    * @return void
    */
	public function addTimerSample(Request $request)
	{
		$loop = \React\EventLoop\Factory::create();
		//var_dump(get_class($loop)); //show the factory choosen implementation

		$loop->addTimer(4, function() use ($loop){
			echo "<br> I will be printed in the browser in 4 seconds, and then I stop the loop";
			$loop->stop();
		});

		$loop->addTimer(2, function(){
			echo "<br> I will be printed in the browser in 2 seconds";
			sleep(1);
		});	

		$loop->run();
	}

	/**
    * Simple addPeriodicTimer Sample
    * @param Request $request - Request data (not used here)
    * @return void
    */
	public function addPeriodicTimerSample(Request $request)
	{
		$loop = \React\EventLoop\Factory::create();

		$count = 0;
		$loop->addPeriodicTimer(1, function() use (&$count){
			echo "<br> I will print this once per second: date-time: ".date('Y-m-d H:i:s').": Count:".$count."<br>";
			$count++;
		});

		$loop->addTimer(10, function() use ($loop){
			echo "<br> After 10 seconds I will stop the loop";
			$loop->stop();
		});

		$loop->run();
	}

	/**
    * Some mixed timers Sample
    * @param Request $request - Request data (not used here)
    * @return void
    */
	public function mixTimersSample(Request $request)
	{
		$loop = \React\EventLoop\Factory::create();

		$loop->addTimer(10, function() use ($loop){
			echo "<br> After 10 seconds I will stop the loop";
			$loop->stop();
		});

		$loop->addTimer(2, function(){
			echo "<br>Just once, After 2 seconds take a sleep of 1 second<br>";
			sleep(1);
		});

		$count = 0;
		$loop->addPeriodicTimer(1, function() use (&$count){
			echo "<br> I will print this once per second: date-time: ".date('Y-m-d H:i:s').": Count:".$count."<br>";
		});

		$loop->run();
	}

	/**
    * Simple cancel timer Sample
    * @param Request $request - (used here just to pass a stop limit)
    * @return void
    */
	public function cancelingTimersSample(Request $request){

		$loop = \React\EventLoop\Factory::create();

		$count = 0;
		$stopLimit = isset($request->stopLimit) ? $request->stopLimit : 5;
		$loop->addPeriodicTimer(2,function(TimerInterface $timer) use (&$count, $loop, $stopLimit) {
			$count++;
			echo "{$count} <br>";
			if($count == $stopLimit) {
				$loop->cancelTimer($timer);
			}
		});

		$loop->run();
		echo "Done\n";
	}

	/**
    * Simple cancel periodic timer Sample
    * @param Request $request - Request data (not used here)
    * @return void
    */
	public function cancelPediodicTimerSample(Request $request){
		$loop = React\EventLoop\Factory::create();
		$count = 0;
		$periodicTimer = $loop->addPeriodicTimer(2,function() use (&$count, $loop) {
			$count++;
			echo "{$count} <br>";
		});

		$loop->addTimer(5,function() use ($periodicTimer, $loop) {
			$loop->cancelTimer($periodicTimer);
		});

		$loop->run();
	}	
}
