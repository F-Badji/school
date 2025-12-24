<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page = 'home')
    {
        return view('home', ['currentPage' => $page]);
    }
}



