<?php

namespace App\Http\Controllers;

use Gate;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\comprtitionInfo;
use App\Models\comprtitionList;
use App\Models\CCoinTable;

class CompritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comprtitionList = comprtitionList::orderBy('id', 'desc')->paginate(15);
        return view('comprtition/index',['comprtitionList'=>$comprtitionList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('check_admin'))
        {
            abort(403);
        }
        return view('comprtition/creat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('check_admin'))
        {
            abort(403);
        }
        $comprtitionList = new comprtitionList;
        $comprtitionList->title = $request->title;
        $comprtitionList->content = $request->content;
        $comprtitionList->type = $request->type;
        $comprtitionList->start_time = $request->start_time;
        $comprtitionList->end_time = $request->end_time;
        $comprtitionList->creat_user = $request->user()->id;
        $comprtitionList->save();

        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'comprtition')
                ->with('where', 'Competition')
                ->with('message', 'Your competition has create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check() && Gate::denies('check_blockade')) 
        {
            $comprtitionConent = comprtitionList::find($id);
            if(Gate::allows('check_admin'))
            {
                $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)->get();
                return view('comprtition/show/admin',["comprtitionConent"=>$comprtitionConent,"comprtitionInfoList"=>$comprtitionInfoList]);
            }
            else
            {
                $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                            ->where('UserName',Auth::user()->name)
                                            ->count();
                //判斷user是否已加入比賽中
                if($comprtitionInfoList != 0){
                    $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                                            ->where('UserName',Auth::user()->name)
                                                            ->first();
                    //判斷是否為比賽時間內
                    //dd($comprtitionInfoList);
                    if(strtotime($comprtitionConent->end_time) - strtotime(date("Y-m-d H:i:s")) > 0 && strtotime(date("Y-m-d H:i:s")) - strtotime($comprtitionConent->start_time) > 0)
                        return view('comprtition/show/user',["comprtitionConent"=>$comprtitionConent,"comprtitionInfo"=>$comprtitionInfoList]);
                    else
                        return view('layouts/success_show')
                                ->with('title', 'Sorry')
                                ->with('link', 'comprtition')
                                ->with('where', 'Competition')
                                ->with('message', 'You cannot goin.It only on '.$comprtitionConent->start_time.' to '.$comprtitionConent->end_time);
                }
                else
                    return view('comprtition/show/add',["comprtitionConent"=>$comprtitionConent]);
            }
        }
        else
        {
            abort(403);
        }
    }

    //將user加入比賽中
    public function addInfo(Request $request,$id)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_blockade'))
        {
            abort(403);
        }
        $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                                ->where('UserName',Auth::user()->name)
                                                ->count();
        if($comprtitionInfoList == 0)
        {
            $comprtitionInfo = new comprtitionInfo;
            $comprtitionInfo->ComprtitionId = $id;
            $comprtitionInfo->UserName = $request->user()->name;
            $comprtitionInfo->save();
            return redirect()->route('comprtition.show',['id' => $id]);
        }
        else
        {
            return view('layouts/success_show')
                    ->with('title', 'Error')
                    ->with('link', 'comprtition')
                    ->with('where', 'Competition')
                    ->with('message', 'Your alrady join it');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        if(Gate::denies('check_admin')){
            abort(403);
        }
        $result = $request->input('data');
        $test = "";
        foreach($result as $post)
        {
            $resultJSON_asn = '{"ans":[';
            $resultJSON_post = ',"post":[';
            foreach($post["result"]["ans"] as $JSON)
            {
                $resultJSON_asn = $resultJSON_asn.$JSON.",";
            }
            foreach($post["result"]["post"] as $JSON)
            {
                $resultJSON_post = $resultJSON_post.$JSON.",";
            }
            $resultJSON_asn = substr($resultJSON_asn,0,-1).']';
            $resultJSON_post = substr($resultJSON_post,0,-1).']';
            $resultJSON = $resultJSON_asn.$resultJSON_post.',"ranking":'.$post["result"]["ranking"].'}';
            $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                                    ->where('UserName',$post["UserName"])
                                                    ->update(['result' => $resultJSON]);
        }
        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'comprtition')
                ->with('where', 'Competition')
                ->with('message', 'Your competition has update');
    }
    
    public function save(Request $request, $id)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_blockade'))
        {
            abort(403);
        }
        $comprtitionConent = comprtitionList::find($id);
        $fileNameList = $request->input('data.topic');
        $contentJSON = '{"code":[';
        //dd($request->input());
        foreach($fileNameList as $fileName)
        {
            //dd($request->file($fileName));
            if ($request->hasFile($fileName))
            {
                $file = $request->file($fileName);
                $extension = $file->getClientOriginalExtension();
                $file_name = strval(time()).'_'.$fileName.'.'.$extension;
                $destination_path = public_path().'/store/userCode/'.Auth::user()->name.'/'.$comprtitionConent->id.'/';
                $upload_success = $file->move($destination_path, $file_name);
                $contentJSON = $contentJSON.'{"topic":"'.$fileName.'","path":"'.$destination_path.$file_name.'"},';
            }
            else{
                $contentJSON = $contentJSON.'{"topic":"'.$fileName.'","path":""},';
            }
        }
        $contentJSON = substr($contentJSON,0,-1).']}';
        $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                                ->where('UserName',Auth::user()->name)
                                                ->update(['content' => $contentJSON]);
        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'comprtition')
                ->with('where', 'Competition')
                ->with('message', 'Your code has save');
    }

    public function vote(Request $request, $id)
    {
        if(!Auth::check())
        {
            abort(403);
        }
        if(Gate::allows('check_blockade'))
        {
            abort(403);
        }
        //dd($request->input());
        $comprtitionConent = comprtitionList::find($id);
        $contentJSON = '{"select":[';
        $result = json_decode($comprtitionConent->content);
        //dd($request);
        foreach($result->select_option as $select_option){
            if($request->has(str_replace(" ","_",$select_option))){
                $contentJSON = $contentJSON.'{"option":"'.$select_option.'","result":1},';
            }else{
                $contentJSON = $contentJSON.'{"option":"'.$select_option.'","result":0},';
            }
        }
        $contentJSON = substr($contentJSON,0,-1).']}';
        $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)
                                                ->where('UserName',Auth::user()->name)
                                                ->update(['content' => $contentJSON]);
        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'comprtition')
                ->with('where', 'Competition')
                ->with('message', 'Your code has save');
    }

    public function settlement(Request $request, $id)
    {
        $comprtitionConent = comprtitionList::find($id);
        if(Gate::denies('check_admin')){
            abort(403);
        }
        if(Gate::denies('update', $comprtitionConent)){
            abort(403);
        }
        //計算所有人應拿之ccoin
        $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)->get();
        foreach($comprtitionInfoList as $comprtitionInfo){
            $CCoinTable = new CCoinTable;
            $result = json_decode($comprtitionInfo->result);
            $ans_count = 0;
            foreach($result->ans as $ans)
                $ans_count += $ans;
            $CCoinTable->details = "You answer ".$ans_count." question and ranking ".$result->ranking." in ".$comprtitionConent->title;
            if($result->ranking < 3)
                $ans_count += (4 - $result->ranking);
            $CCoinTable->name = $comprtitionInfo->UserName;
            $CCoinTable->money = 2 + $ans_count;
            $CCoinTable->type = "InsideCommunity";
            $CCoinTable->save();
        }
        //將比賽鎖定
        $comprtitionConent->Settlement = 1;
        $comprtitionConent->save();
        return view('layouts/success_show')
                ->with('title', 'Success')
                ->with('link', 'comprtition')
                ->with('where', 'Competition')
                ->with('message', 'Your competition has settlement');
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
        $comprtitionConent = comprtitionList::find($id);
        $comprtitionConent->delete();
        if ($comprtitionConent->trashed()) {
            $comprtitionInfoList = comprtitionInfo::where('ComprtitionId',$id)->get();
            foreach($comprtitionInfoList as $comprtitionInfo)
                $comprtitionInfo->delete();
            return view('layouts/success_show')
                    ->with('title', 'Success')
                    ->with('link', 'comprtition')
                    ->with('where', 'Comprtition')
                    ->with('message', 'Your comprtition was delete');
        }else{
            abort(503);
        }
    }
}
