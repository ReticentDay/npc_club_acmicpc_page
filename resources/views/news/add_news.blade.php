@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add News

                </div>
                <div class="panel-body">
                    @can('check_admin')
                    <form id="newsFrom" action="/news/to_add_news" method="post">
                        {!! csrf_field() !!}
                        <input type="text" id="titleInput" class="form-control" name="title" value="" placeholder="title">
                        <input type="hidden" id='content' name="content">
                        <div id="summernote">Enter Your News</div>
                        <select class="from-control" name="type">
                            <option value="system">system</option>
                            <option value="comprition">comprition</option>
                            <option value="event">event</option>
                            <option value="other">other</option>
                        </select>
                        <input type="submit" id="submit" class="btn btn-success btn-xs" value="submit">
                    </form>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['style','bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript','link']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['codeview',['codeview']]
            ],
            height: 300,                 // set editor height
            focus: true,                  // set focus to editable area after initializing summernote
        });
        $('#newsFrom').submit(function(e){
            $('#content').attr("value", $('#summernote').summernote('code'));
        });
    });
</script>
@endsection
