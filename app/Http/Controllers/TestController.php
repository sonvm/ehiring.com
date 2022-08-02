<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(){

        $this->middleware('Second');

        $this->middleware('Third');
    }

    public function testControllerMiddleware(){

        echo '<br>Hàm testControllerMiddleware trong controller';
    }
}
