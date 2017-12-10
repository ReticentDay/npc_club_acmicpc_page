<?php

namespace App\Http\Controllers;

use Gate;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\NewsList;

class NewsController extends Controller
{
    public function newsList(Request $request){
        $newsList = NewsList::orderBy('id', 'desc')->paginate(10);
        if ($request->has('find_type')) {
            $newsList = NewsList::where('type',$request->find_type)->orderBy('id', 'desc')->paginate(10);
        }
        return view('news/news_list',['newsList'=>$newsList]);
    }
    public function addNews(){
        if(Gate::denies('check_admin')){
            abort(403);
        }
        return view('news/add_news');
    }
    public function showNews(Request $request){
        $news = NewsList::find($request->id);
        return view('news/news_file',['News'=>$news]);
    }
    public function toAddNews(Request $request){
        if(Gate::denies('check_admin')){
            abort(403);
        }
        $newsList = new NewsList;
        $newsList->title = $request->title;
        $newsList->content = $request->content;
        $newsList->type = $request->type;
        $newsList->save();

        $user = Auth::user()->name;
        $message = array("message" => $request->title,"type"=>$request->type,"link"=>"http://acmicpc.ntut.club/news");
        event(new \App\Events\ChatMessageWasReceived($message, $user));

        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'news')
                ->with('where', 'News')
                ->with('message', 'Your news was save');
    }
    public function toDeleteNews(Request $request){
        if(Gate::denies('check_admin')){
            abort(403);
        }
        $news = NewsList::find($request->id);
        $news->delete();
        if ($news->trashed()) {
            return view('layouts/success_show')
                    ->with('title', 'Success')
                    ->with('link', 'news')
                    ->with('where', 'News')
                    ->with('message', 'Your news was delete');
        }else{
            abort(503);
        }
    }
}
