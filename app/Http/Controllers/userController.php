<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use App\Http\Controllers\Controller;

use App\tests;

class userController extends Controller
{
    /**
     * 顯示給定使用者的個人資料。
     *
     * @param  int  $id
     * @return Response
     */

    public function showProfile(Request $request)
    {
        $input = [
            'name'=>'FFd',
            'message'=>'test content',
            'cat_id'=>1,
            'views'=>100,
            'user_id'=>2
        ];
        $this->middleware('OldMiddleware');
        $post = tests::create($request->input());
        dd($post);
        //return $request->input();
        //return $input;
        //dd($tests);
    }
}
