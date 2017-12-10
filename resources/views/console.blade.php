@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_CCoin_List">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#CCoin_List" aria-expanded="true" aria-controls="CCoin_List">
                                CCoin Rank
                            </a>
                        </h4>
                    </div>
                    <div id="CCoin_List" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_CCoin_List">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                @foreach($CCoinTable as $CCoin)
                                    <tr>
                                        <td>
                                            <div class="col-md-2 col-sm-2 col-xs-2">{{ $CCoin->sum }}</div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">{{ $CCoin->name }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_User_List">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#User_List" aria-expanded="false" aria-controls="User_List">
                                User List
                            </a>
                        </h4>
                    </div>
                    <div id="User_List" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_User_List">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                @foreach($userList as $user)
                                    <tr>
                                        <td>
                                            <form class="user_modify" action="/console/{{ $user->id }}/modify" method="post">
                                                {!! csrf_field() !!}
                                                <div class="col-md-2 col-sm-2 col-xs-2">{{ $user->name }}</div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">{{ $user->email }}</div>
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <select class="form-control" name="type">
                                                        <option value="{{ $user->type }}">{{ $user->type }}</option>
                                                        <option value="user">user</option>
                                                        <option value="admin">admin</option>
                                                        <option value="bucket">bucket</option>
                                                        <option value="blockade">blockade</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-2"><input class="btn btn-success btn-block" type="submit" name="" value="modify"></div>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_AddCCoin">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#AddCCoin" aria-expanded="false" aria-controls="AddCCoin">
                                Add CCoin
                            </a>
                        </h4>
                    </div>
                    <div id="AddCCoin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_AddCCoin">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                @foreach($userList as $user)
                                    <tr>
                                        <td>
                                            <form class="user_modify" action="/console/AddCCoin" method="post">
                                                {!! csrf_field() !!}
                                                <div class="col-md-2 col-sm-2 col-xs-2">{{ $user->name }}<input type="hidden" name="name" value="{{ $user->name }}"></div>
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <input type="text" class="form-control" name="money" placeholder="How many">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <select class="form-control" name="type">
                                                        <option value="Competition">Competition</option>
                                                        <option value="Discuss excellent">Discuss excellent</option>
                                                        <option value="Special performance">Special performance</option>
                                                        <option value="other">other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4"><input type="text" class="form-control" name="details" placeholder="Why"></div>
                                                <div class="col-md-2 col-sm-2 col-xs-2"><input class="btn btn-success btn-block" type="submit" name="" value="modify"></div>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_Reset_Season">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Reset_Season" aria-expanded="false" aria-controls="Reset_Season">
                                Reset Season
                            </a>
                        </h4>
                    </div>
                    <div id="Reset_Season" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_Reset_Season">
                        <div class="panel-body">
                            <form class="reset_form" action="/console/reset/season" method="post">
                                {!! csrf_field() !!}
                                <input class="btn btn-success btn-block" type="submit" name="" value="reset">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $(".user_modify").submit(function(){
            if(!confirm("Are You Sure?")){
                return false;
            }
        });
        $(".reset_form").submit(function(){
            if(!confirm("The all competition、ccoin will reset.Are You Sure To Do This?")){
                return false;
            }
        });
    });
</script>
@endsection
