<?php

namespace App\Http\Controllers;

use Gate;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\CCoinTable;
use App\Models\comprtitionList;
use App\Models\communityReply;
use App\Models\communityTable;
use App\Models\communityGood;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communityTable = communityTable::orderBy('id', 'desc')->paginate(10);
        $communityJson = '{"community":[';
        foreach($communityTable as $community){
            $communityCount = communityGood::where('community_id',$community->id)->count();
            $communityReply = communityReply::where('community_id',$community->id)->count();
            $communityJson = $communityJson.'{"id":'.$community->id.',"count":'.$communityCount.',"reply":'.$communityReply.'},';
        }
        $communityJson = substr($communityJson,0,-1).']}';
        return view('commnity/index',['communityTable'=>$communityTable,'communityJson'=>$communityJson]);
    }

    public function search($find_type)
    {
        $communityTable = communityTable::where('type',$find_type)->orderBy('id', 'desc')->paginate(10);
        $communityJson = '{"community":[';
        foreach($communityTable as $community){
            $communityCount = communityGood::where('community_id',$community->id)->count();
            $communityJson = $communityJson.'{"id":'.$community->id.',"count":'.$communityCount.'},';
        }
        $communityJson = substr($communityJson,0,-1).']}';
        return view('commnity/index',['communityTable'=>$communityTable,'communityJson'=>$communityJson]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }
        return view('commnity/creat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }
        $communityTable = new communityTable;
        $communityTable->title = $request->title;
        $communityTable->content = $request->content;
        $communityTable->type = $request->type;
        $communityTable->association = $request->association;
        $communityTable->creat_user = $request->user()->name;
        $communityTable->save();

        $CCoinTable = new CCoinTable;
        $CCoinTable->details = "Your creat a new article 【".$request->title."】";
        $CCoinTable->name = $request->user()->name;
        $CCoinTable->money = 3;
        $CCoinTable->type = "community";
        $CCoinTable->save();

        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'community')
                ->with('where', 'Community')
                ->with('message', 'Your article has create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $communityTable = communityTable::find($id);
        $communityReplyList = communityReply::where('community_id',$id)->get();
        $communityGood = communityGood::where('community_id',$id)->count();
        if(Auth::check())
        {
            $communityGoodHas = communityGood::where('community_id',$id)->where('user_name',Auth::user()->name)->count();
            return view('commnity/show',[   'communityTable'=>$communityTable,
                                            'communityReplyList'=>$communityReplyList,
                                            'communityGoodHas'=>$communityGoodHas,
                                            'communityGood'=>$communityGood]);
        }
        return view('commnity/show',[   'communityTable'=>$communityTable,
                                        'communityReplyList'=>$communityReplyList,
                                        'communityGood'=>$communityGood]);
    }

    public function like(Request $request,$id){
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }
        $communityGood = communityGood::where('community_id',$id)->where('user_name',$request->user()->name)->count();
        if($communityGood > 0){
            return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'community/'.$id)
                ->with('where', 'article')
                ->with('message', 'You was say this article good');
        }else{
            $communityGoodAdd = new communityGood;
            $communityGoodAdd->community_id = $id;
            $communityGoodAdd->user_name = $request->user()->name;
            $communityGoodAdd->save();
            $communityTable = communityTable::find($id);
            $CCoinTable = new CCoinTable;
            $CCoinTable->details = "The ".$request->user()->name." say your ".$communityTable->title." good";
            $CCoinTable->name = $communityTable->creat_user;
            $CCoinTable->money = 1;
            $CCoinTable->type = "community";
            $CCoinTable->save();
            return redirect()->route('community.show',['id' => $id]);
        }
    }

    public function reply(Request $request,$id){
        //dd($request->user());
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }

        $communityReply = new communityReply;
        $communityReply->community_id = $id;
        $communityReply->creat_user = $request->user()->name;
        $communityReply->content = $request->input('content');
        $communityReply->save();
        return redirect()->route('community.show',['id' => $id]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }
        $communityTable = communityTable::find($id);
        //dd($communityTable);
        if(Gate::denies('updateName', $communityTable)){
            abort(403);
        }
        return view('commnity/edit',['communityTable'=>$communityTable]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_bucket'))
        {
            abort(403);
        }
        $communityTable = communityTable::find($id);
        if(Gate::denies('updateName', $communityTable)){
            abort(403);
        }
        $communityTable->title = $request->title;
        $communityTable->content = $request->content;
        $communityTable->type = $request->type;
        $communityTable->association = $request->association;
        $communityTable->creat_user = $request->user()->name;
        $communityTable->save();

        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'community')
                ->with('where', 'Community')
                ->with('message', 'Your article has update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('check_root')){
            abort(403);
        }
        $communityTable = communityTable::find($id);
        $communityTable->delete();
        if ($communityTable->trashed()) {
            $communityReplyList = communityReply::where('community_id',$id)->get();
            foreach($communityReplyList as $communityReply)
                $communityReply->delete();
            return view('layouts/success_show')
                    ->with('title', 'Success')
                    ->with('link', 'community')
                    ->with('where', 'Community')
                    ->with('message', 'Your comprtition was delete');
        }else{
            abort(503);
        }
    }
}
