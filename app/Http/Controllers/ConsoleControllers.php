<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\NewsList;

class ConsoleControllers extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('InfoMiddleware');
    }

    public function index(){
        return view('admin_info');
    }

    public function newsList(){
        $newsList = NewsList::paginate(3);
        return view('console_news_list',['newsList'=>$newsList]);
    }
}
