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
                    <span class="label label-primary">{{ $comprtitionConent->type }}</span>
                    {{ $comprtitionConent->title }}
                </div>
                <div class="panel-body">
                    <b>start_time</b> : {{ $comprtitionConent->start_time }}<br>
                    <b>end_time</b> : {{ $comprtitionConent->end_time }}<br>
                    <b>more</b><br>
                    <p id="more"></p>
                    <hr>
                    @if($comprtitionConent->type == "InsideCommunity")
                        <b>Update Your Code:</b>
                        <form  role="form" action="/comprtition/{{ $comprtitionConent->id }}/save" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="UserName" value="{{ $comprtitionInfo->UserName }}">
                            <b>Topic</b><br>
                            <div id="topic_list">
                            </div>
                            <input type="submit" name="" value="submit">
                        </form>
                    @elseif($comprtitionConent->type == "vote")
                        <form id="voteForm" role="form" action="/comprtition/{{ $comprtitionConent->id }}/vote" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <b>select option</b><br>
                            <div id="vote_list" class="form-check"></div>
                            <input id="vote_submit" class="btn btn-success" type="submit" name="" value="submit">
                            <fieldset disabled id="disabled_vote_submit">
                                <input id="vote_submit" class="btn btn-success" type="submit" name="" value="submit">
                            </fieldset>
                        </form>
                    @else
                        <p id="official_link"><b>official link:</b></p>
                        <p id="sing_up_link"><b>sing_up_link:</b></p>
                    @endif
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
                var $liElement = $("<div class='row'></div>")
                $liElement.append('<label for="' + content.topic[$topic] + '" class="control-label col-md-2 col-sm-4 col-xs-12 text-center">' + content.topic[$topic] + '</label>');
                var $divElement = $('<div class="col-md-10 col-sm-8 col-xs-12"></div>');
                var $hiddenElement = $('<input type="hidden" name="data[topic][' + content.topic[$topic] + ']" value="' + content.topic[$topic].replace(/ /g,"_") + '">');
                var $fileElement = $('<input type="file" class="form-control" id="' + content.topic[$topic] + '" name="' + content.topic[$topic].replace(/ /g,"_") + '" value="">');
                $divElement.append($hiddenElement);
                $divElement.append($fileElement);
                $liElement.append($divElement);
                $("#topic_list").append($liElement);
            }
        @elseif($comprtitionConent->type == "vote")
            $("#vote_submit").show();
            $("#disabled_vote_submit").hide();
            var $much = content.much;
            $("#vote_list").append('<div id="much">you can select ' + $much + '</div>');

            for (var $select_option in content.select_option) {
                $("#vote_list").append('<label class="form-check-label"><input id="' + content.select_option[$select_option].replace(/ /g,"_") + '" class="form-check-input vote_check" type="checkbox" name="' + content.select_option[$select_option].replace(/ /g,"_") + '" value="' + content.select_option[$select_option] + '">' + content.select_option[$select_option] + '</label><br />');
            }
            console.log({!! $comprtitionInfo->content !!});
            if({{ $comprtitionInfo->content ? 1 : 0 }}){
                var $select = JSON.parse('{!! $comprtitionInfo->content !!}');
                for(var $select_option in $select.select){
                    var $select_result = $select.select[$select_option].result;
                    var $select_option_name = $select.select[$select_option].option;
                    if($select_result == 1){
                        $("#" + $select_option_name.replace(/ /g,"_")).prop('checked',true);
                        //console.log("1");
                    }
                }
            }
            $(".vote_check").change(function(e){
                var $count = 0;
                $(".vote_check").each(function(){
                    if($(this).prop('checked'))
                        $count++;
                });
                console.log($count);
                if($count > $much){
                    $("#vote_submit").hide();
                    $("#disabled_vote_submit").show();
                }
                else{
                    $("#vote_submit").show();
                    $("#disabled_vote_submit").hide();
                }
            });
        @else
            $("#official_link").append("<a href=" + content.official_link + ">" + content.official_link + "</a>");
            $("#sing_up_link").append("<a href=" + content.sing_up_link + ">" + content.sing_up_link + "</a>");
        @endif
        $("#more").append(content.more);
    });
</script>
@endsection
