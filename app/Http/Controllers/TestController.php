<?php

namespace App\Http\Controllers;

use GeoIP;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Store new test.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$test = Test::create([
    		'data'     => $request->all(),
    		'ip'       => $request->ip(),
            'location' => GeoIP::getLocation()->toArray(),
            'user_agent' => $request->header('User-Agent')
    	]);

        return $test->id;
    }
}
