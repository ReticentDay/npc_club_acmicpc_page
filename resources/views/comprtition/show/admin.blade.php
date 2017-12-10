@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/comprtition">comprtition</a></li>
                <li>{{ $comprtitionConent->title }}</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="container">
                        <span class="label label-primary">{{ $comprtitionConent->type }}</span>
                        {{ $comprtitionConent->title }}

                    </div>
                </div>
                <div class="panel-body">
                    @can('check_admin')
                        <b>start_time</b> : {{ $comprtitionConent->start_time }}<br>
                        <b>end_time</b> : {{ $comprtitionConent->end_time }}<br>
                        @if($comprtitionConent->type == "InsideCommunity")
                            <b>Topic</b><br>
                            <ul id="topic_list">
                            </ul>
                        @elseif($comprtitionConent->type == "vote")

                        @else
                            <p id="official_link"><b>official link:</b></p>
                            <p id="sing_up_link"><b>sing_up_link:</b></p>
                        @endif
                        <b>more</b><br>
                        <p id="more"></p>
                        @if($comprtitionConent->type == "InsideCommunity")
                            <form role="form" action="/comprtition/{{ $comprtitionConent->id }}" method="post">
                                @if($comprtitionConent->Settlement == 1)
                                <fieldset disabled>
                                @endif
                                <input type="hidden" name="_method" value="PATCH">
                                {!! csrf_field() !!}
                                <input type="hidden" name="ComprtitionId" value="{{ $comprtitionConent->id }}">
                                @foreach ($comprtitionInfoList as $post)
                                    <div id="{{ $post->UserName }}" class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-12"></div>
                                        <div class="col-md-10 col-sm-8 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6 text-center">asn</div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 text-center">post</div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($comprtitionConent->Settlement == 0)
                                <input class="btn btn-success" type="submit" name="" value="Save">
                                @endif
                                @if($comprtitionConent->Settlement == 1)
                                </fieldset>
                                @endif
                            </form>
                            @if($comprtitionConent->Settlement == 0)
                                @can('update' , $comprtitionConent)
                                    <form class="" action="/comprtition/{{ $comprtitionConent->id }}/Settlement" method="post">
                                        {!! csrf_field() !!}
                                        <input class="btn  btn-warning" type="submit" name="" value="Settlement">
                                    </form>
                                @endcan
                            @endif
                        @elseif($comprtitionConent->type == "vote")
                            <b>select option</b><br>
                            <fieldset disabled>
                            <div id="vote_list">
                            </div>
                            </fieldset>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingAllVote">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAllVote" aria-expanded="false" aria-controls="collapseAllVote">
                                                show all vote
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAllVote" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAllVote">
                                        <div class="panel-body">
                                            <table class="table table-hover table-striped" id="AllVote">
                                                <tr id="AllVoteHead">
                                                    <th>user</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingAllAdd">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAllAdd" aria-expanded="false" aria-controls="collapseAllAdd">
                                                show all add
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAllAdd" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAllAdd">
                                        <div class="panel-body">
                                            <table class="table table-hover table-striped" id="AllVote">
                                                <tr id="AllVoteHead">
                                                    <th>user</th>
                                                    <th>time</th>
                                                </tr>
                                                @foreach ($comprtitionInfoList as $post)
                                                    <tr>
                                                        <td>{{ $post->UserName }}</td>
                                                        <td>{{ $post->created_at }}</td>
                                                    <tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var content = JSON.parse('{!! $comprtitionConent->content !!}');
        @if($comprtitionConent->type == "InsideCommunity")
            console.log(content.topic);
            for (var $topic in content.topic) {
                console.log(content.topic[$topic]);
                $("#topic_list").append("<li>" + content.topic[$topic] + "</li>");
            }
            @foreach ($comprtitionInfoList as $post)
                $("#{{$post->UserName}}").append('<input type="hidden" name="data[{{ $post->UserName }}][UserName]" value="{{ $post->UserName }}">');
                $("#{{$post->UserName}}").append('<label for="result_{{ $post->UserName }}" class="control-label col-md-2 col-sm-4 col-xs-12 text-center">{{ $post->UserName }}</label>');
                $divElemet = $('<div class="col-md-10 col-sm-8 col-xs-12"></div>');
                var result = JSON.parse('{!! $post->result or "{}"!!}');
                for(var i = 0;i < content.topic.length; i++){
                    if (result.ans) {
                        $divElemet.append('<div class="col-md-6 col-sm-6 col-xs-6"><input type="number" name="data[{{ $post->UserName }}][result][ans][]" class="form-control" id="" value="' + result.ans[i]  + '"></div>');
                        $divElemet.append('<div class="col-md-6 col-sm-6 col-xs-6"><input type="number" name="data[{{ $post->UserName }}][result][post][]" class="form-control" id="" value="' + result.post[i]  + '"></div>');
                    }else{
                        $divElemet.append('<div class="col-md-6 col-sm-6 col-xs-6"><input type="number" name="data[{{ $post->UserName }}][result][ans][]" class="form-control" id="" value="0"></div>');
                        $divElemet.append('<div class="col-md-6 col-sm-6 col-xs-6"><input type="number" name="data[{{ $post->UserName }}][result][post][]" class="form-control" id="" value="0"></div>');
                    }
                }
                if (result.ranking) {
                    $divElemet.append('<div class="col-md-12 col-sm-12 col-xs-12"><div class="col-md-2 col-sm-4 col-xs-4">Ranking</div><div class="col-md-10 col-sm-8 col-xs-8"><input type="number" class="form-control" name="data[{{ $post->UserName }}][result][ranking]" value="'+result.ranking+'"></div></div>');
                }else{
                    $divElemet.append('<div class="col-md-12 col-sm-12 col-xs-12"><div class="col-md-2 col-sm-4 col-xs-4">Ranking</div><div class="col-md-10 col-sm-8 col-xs-8"><input type="number" class="form-control" name="data[{{ $post->UserName }}][result][ranking]" value="0"></div></div>');
                }
                $("#{{$post->UserName}}").append($divElemet);

            @endforeach
        @elseif($comprtitionConent->type == "vote")
            for (var $select_option in content.select_option) {
                $("#vote_list").append('<div class="col-md-2 col-sm-4 col-xs-12">' + content.select_option[$select_option] + ':</div><div class="col-md-10 col-sm-8 col-xs-12"><input class="vote_count"  type="hidden" id="' + content.select_option[$select_option].replace(/ /g,"_") + '" value="0"></div>');
                $("#AllVoteHead").append('<th>' + content.select_option[$select_option] + '</th>');
            }
            var $all = {{count($comprtitionInfoList)}};
            console.log($all);
            @foreach ($comprtitionInfoList as $post)
                var $result = JSON.parse('{!! $post->content or "{}" !!}');
                var $AllVoteLine = $('<tr></tr>');
                $AllVoteLine.append('<td>{{ $post->UserName }}</td>');
                for(var $select_option in $result.select){
                    var $count = parseInt($("#" + $result.select[$select_option].option.replace(/ /g,"_")).val()) + $result.select[$select_option].result;
                    $("#" + $result.select[$select_option].option.replace(/ /g,"_")).val($count.toString());
                    $AllVoteLine.append('<td>' + $result.select[$select_option].result + '</td>');
                }
                $('#AllVote').append($AllVoteLine);
            @endforeach
            $(".vote_count").each(function(){
                $(this).after('<div class="progress"><div class="progress-bar" role="progressbar" style="width: ' + Math.round($(this).val()/$all*100) + '%;" aria-valuenow="' + $(this).val() + '" aria-valuemin="0" aria-valuemax="' + $all + '">' + $(this).val() + '</div></div>');
            });
        @else
            $("#official_link").append("<a href=" + content.official_link + ">" + content.official_link + "</a>");
            $("#sing_up_link").append("<a href=" + content.sing_up_link + ">" + content.sing_up_link + "</a>");
        @endif

        $("#more").append(content.more);
    });
</script>
@endsection
