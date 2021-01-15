<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * GET /
     * ホーム画面を表示する
     */
    public function index()
    {
        return view('home');
    }
}
