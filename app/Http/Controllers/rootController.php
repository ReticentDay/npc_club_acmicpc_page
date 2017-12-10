<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Gate;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\NewsList;
use App\Models\CCoinTable;
use App\Models\comprtitionList;
use App\Models\comprtitionInfo;
use App\Models\communityTable;

class rootController extends Controller
{

    public function showProfile(){
        $newsList = NewsList::orderBy('id', 'desc')->take(10)->get();
        $CCoinTable = CCoinTable::groupBy('name')->select(DB::raw('SUM(money) as sum, name'))->orderBy('sum', 'desc')->take(5)->get();
        $comprtitionList = comprtitionList::orderBy('id', 'desc')->select('id','title','type')->take(5)->get();
        //dd($CCoinTable);
        return view('root',['newsList'=>$newsList,'CCoinTable'=>$CCoinTable,'comprtitionList'=>$comprtitionList]);
    }
    public function info(){
        if(!Auth::check())
        {
            abort(403);
        }
        $CCoinTable = CCoinTable::groupBy('name')->select(DB::raw('SUM(money) as sum, name'))->orderBy('sum', 'desc')->get();
        $CCoinInfo = CCoinTable::where('name',Auth::user()->name)->get();
        $communityTable = communityTable::where('creat_user', Auth::user()->name)->select('id','creat_user','type','association','title')->get();
        $comprtitionInfo = comprtitionInfo::where('UserName', Auth::user()->name)->join('comprtitionList', 'comprtitionInfo.ComprtitionId', '=', 'comprtitionList.id')->get();

        foreach($CCoinTable as $CCoinKey=>$CCoin) {
            if($CCoin->name == Auth::user()->name){
                return view('user_info',[   'CCoinHas'=>$CCoin->sum,
                                            'CcoinRank'=>$CCoinKey+1,
                                            'CCoinTable'=>$CCoinInfo,
                                            'communityTable'=>$communityTable,
                                            'comprtitionInfo'=>$comprtitionInfo]);
            }
        }
        return view('user_info',[   'CCoinHas'=>0,
                                    'CcoinRank'=>0,
                                    'CCoinTable'=>$CCoinInfo,
                                    'communityTable'=>$communityTable,
                                    'comprtitionInfo'=>$comprtitionInfo]);

    }
    public function console(){
        if(Gate::denies('check_root')){
            abort(403);
        }
        $UserList = User::where('type','<>','root')->get();
        $CCoinTable = CCoinTable::groupBy('name')->select(DB::raw('SUM(money) as sum, name'))->orderBy('sum', 'desc')->get();
        return view('console',['userList' => $UserList,'CCoinTable' => $CCoinTable]);
    }
    public function modify(Request $request,$id){
        if(Gate::denies('check_root')){
            abort(403);
        }
        $UserList = User::find($id);
        $UserList->type =  $request->input('type');
        $UserList->save();
        return redirect()->route('consoleIndex');
    }
    public function AddCCoin(Request $request){
        if(Gate::denies('check_root')){
            abort(403);
        }
        $CCoinList = new CCoinTable;
        $CCoinList->name = $request->name;
        $CCoinList->money = $request->money;
        $CCoinList->type = $request->type;
        $CCoinList->details = $request->details;
        $CCoinList->save();
        return redirect()->route('consoleIndex');
    }
    public function reset(Request $request){
        if(Gate::denies('check_root')){
            abort(403);
        }
        $comprtitionInfo = comprtitionInfo::get();
        foreach($comprtitionInfo as $post)$post->delete();
        $comprtitionList = comprtitionList::get();
        foreach($comprtitionList as $post)$post->delete();
        $CCoinTable = CCoinTable::get();
        foreach($CCoinTable as $post)$post->delete();
        return redirect()->route('consoleIndex');
    }
}
