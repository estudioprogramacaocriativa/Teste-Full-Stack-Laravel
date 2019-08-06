<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function resolve(Request $request)
    {
        sleep(2);
        $controller = "{$request->item_controller}";
        $invoque = new $controller;
        $method = !empty($request->method) && $request->method !== 'undefined' && $request->method !== 'null' ? $request->method : "destroy";

        return $invoque->$method($request->item_id);
    }    
}
