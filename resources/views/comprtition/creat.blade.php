@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/comprtition">comprtition</a></li>
                <li>Add Comprition</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Comprition
                </div>
                <div class="panel-body">
                    @can('check_admin')
                        <form id="comprtitionFrom" role="form" action="/comprtition" method="post">
                            {!! csrf_field() !!}
                            <input type="hidden" id='content' name="content">

                            <!--選項(社團活動、投票、比賽)-->
                            <div class="radio">
                                <label class="radio-inline"><input type="radio" name="type" value="InsideCommunity" checked>InsideCommunity</label>
                                <label class="radio-inline"><input type="radio" name="type" value="vote">vote</label>
                                <label class="radio-inline"><input type="radio" name="type" value="comprtition">comprtition</label>
                            </div>
                            <!--比賽名稱-->
                            <input type="text" class="form-control" placeholder="title" name="title" value="">
                            <!--起始、結束時間-->
                            <label for="start_time" class="control-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="start_time" name="start_time">
                            <label for="end_time" class="control-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="end_time" name="end_time">
                            <!--詳細內容-->
                            <hr id="content-bar" />
                            <div class="InsideCommunity">
                                <input type="text" id="topic-first" class="form-control" placeholder="topic">
                                <button class="btn btn-success" id="add-topic" type="button" name="button" >Add</button>
                            </div>
                            <div class="vote">
                                <input type="text" id="select-much" class="form-control" placeholder="how many option can select?">
                                <input type="text" id="select-first" class="form-control" placeholder="select option">
                                <button class="btn btn-success" id="add-select" type="button" name="button" >Add</button>
                            </div>
                            <div class="comprtition">
                                <input type="text" class="official-link form-control" placeholder="official link">
                                <input type="text" class="sing-up-link form-control" placeholder="sing-up link">
                            </div>
                            <hr id="more-bar">
                            <!--補充-->
                            <textarea rows="8" cols="80" class="form-control" id="more" placeholder="more"></textarea>
                            <hr>
                            <div class="text-right"><input class="btn btn-success" type="submit" name="" value="submit"></div>
                        </form>
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
        //預設顯示狀態
        $(".InsideCommunity").show();
        $(".comprtition").hide();
        $(".vote").hide();
        //選項切換顯示狀態
        $("input[name='type']:radio").change(function(){
            //社團活動狀態
            if ($("input:radio:checked[name='type']").val() == "InsideCommunity") {
                $(".InsideCommunity").show();
                $(".comprtition").hide();
                $(".vote").hide();
            }
            //投票狀態
            if ($("input:radio:checked[name='type']").val() == "vote") {
                $(".InsideCommunity").hide();
                $(".comprtition").hide();
                $(".vote").show();
            }
            //比賽狀態
            if ($("input:radio:checked[name='type']").val() == "comprtition") {
                $(".InsideCommunity").hide();
                $(".comprtition").show();
                $(".vote").hide();
            }
        });
        //增加比賽題目按鈕
        $("#add-topic").click(function(){
            var topic="<input type='text' class='topic form-control' placeholder='topic'>";
            $("#add-topic").before(topic);
        });
        //增加投票選項按鈕
        $("#add-select").click(function(){
            var select="<input type='text' class='select-option form-control' placeholder='select option'>";
            $("#add-select").before(select);
        });
        //送出前將資料合併至content
        $("#comprtitionFrom").submit(function(e){
            var $content = '';
            if ($("input:radio:checked[name='type']").val() == "InsideCommunity") {
                $content = '"topic":["' + $("#topic-first").val() + '"';
                $(".topic").each(function(){
                    $content += ',"' + $(this).val() + '"';
                });
                $content += ']';
            }
            if ($("input:radio:checked[name='type']").val() == "vote") {
                $content = '"select_option":["' + $("#select-first").val() + '"';
                $(".select-option").each(function(){
                    $content += ',"' + $(this).val() + '"';
                });
                $content += ']';
                $content += ',"much":"' + $("#select-much").val() + '"';
            }
            if ($("input:radio:checked[name='type']").val() == "comprtition") {
                $content = '"official_link":"' + $(".official-link").val() + '"';
                $content += ',"sing_up_link":"' + $(".sing-up-link").val() + '"';
            }
            var str = $("#more").val().replace(/\n/g,"<br />");
            $content += ',"more":"' + str + '"';
            $content = '{' + $content + '}';
            $('#content').attr("value", $content);
        });
    });
</script>
@endsection
