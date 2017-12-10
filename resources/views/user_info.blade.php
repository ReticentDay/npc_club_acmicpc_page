@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Your stage</h3>
                        <p>
                            <b>Name:</b>{{ Auth::user()->name }}<br>
                            <b>type:</b>{{ Auth::user()->type }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Your CCoin</h3>
                        <h1>{{ $CCoinHas }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Number of competition</h3>
                        <h1>{{ $comprtitionInfo->where('type','InsideCommunity')->count() }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Number of articles</h3>
                        <h1>{{ $communityTable->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Answer rate</h3>
                        <h1 id="rate"></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Your Rank</h3>
                        <h1>{{ $CcoinRank }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_CCoin_List">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#CCoin_List" aria-expanded="true" aria-controls="CCoin_List">
                                Your CCoin List
                            </a>
                        </h4>
                    </div>
                    <div id="CCoin_List" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_CCoin_List">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                            @foreach($CCoinTable as $CCoin)
                                <tr>
                                    <td>
                                        <div class="col-md-2 col-sm-2 col-xs-2">{{ $CCoin->type }}</div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">{{ $CCoin->money }}</div>
                                        <div class="col-md-8 col-sm-8 col-xs-8">{{ $CCoin->details }}</div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_Community_List">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Community_List" aria-expanded="false" aria-controls="Community_List">
                                Your Community List
                            </a>
                        </h4>
                    </div>
                    <div id="Community_List" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_Community_List">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                            @foreach($communityTable as $Community)
                                <tr>
                                    <td>
                                        <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $Community->type }}</span></div>
                                        <div class="col-md-10 col-sm-10 col-xs-10"><a href="/community/{{ $Community->id }}">【{{ $Community->association }}】{{ $Community->title }}</a></div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_Comprtition_List">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Comprtition_List" aria-expanded="false" aria-controls="Comprtition_List">
                                Your comprtition List
                            </a>
                        </h4>
                    </div>
                    <div id="Comprtition_List" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_Comprtition_List">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                            @foreach($comprtitionInfo as $comprtition)
                                <tr>
                                    <td>
                                        <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $comprtition->type }}</span></div>
                                        <div class="col-md-10 col-sm-10 col-xs-10"><a href="/comprtition/{{ $comprtition->ComprtitionId }}">{{ $comprtition->title }}</a></div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
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
        var $asn = 0;
        var $post = 0;
        var $content;
        @foreach($comprtitionInfo->where('type','InsideCommunity') as $comprtition)
            $content = JSON.parse('{!! $comprtition->result or "{}" !!}');
            for(var i in $content.ans)
                $asn += $content.ans[i];
            for(var i in $content.post)
                $post += $content.post[i];
        @endforeach
        if($post != 0)
            $("#rate").append(Math.round($asn / $post * 100) + "%");
        else
            $("#rate").append("0%");
    });
</script>
@endsection
