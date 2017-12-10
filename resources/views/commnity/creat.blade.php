@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add article

                </div>
                <div class="panel-body">
                    @if (Auth::check())
                    <form role="form" id="newsFrom" action="/community" method="post">
                        {!! csrf_field() !!}
                        <div id="titleRow" class="row">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label for="titleInput">title</label>
                            </div>
                            <div class="col-md-10 col-sm-8 col-xs-12">
                                <input type="text" id="titleInput" class="form-control" name="title" value="" placeholder="title">
                            </div>
                        </div>
                        <div id="titleRow" class="row">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label for="typeSelect" class="control-label">type</label>
                            </div>
                            <div class="col-md-10 col-sm-8 col-xs-12">
                                <select id="typeSelect" class="form-control" name="type">
                                    <option value="other">other</option>
                                    <option value="comprition">comprition</option>
                                    <option value="question">question</option>
                                    <option value="system">system</option>
                                </select>
                            </div>
                        </div>
                        <div id="titleRow" class="row">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label for="titleInput">association</label>
                            </div>
                            <div class="col-md-10 col-sm-8 col-xs-12">
                                <input type="text" id="titleInput" class="form-control" name="association" value="" placeholder="association">
                            </div>
                        </div>


                        <input type="hidden" id='content' name="content">
                        <div id="summernote">Enter Your article</div>

                        <input type="submit" id="submit" class="btn btn-success btn-xs" value="submit">
                    </form>
                    @endif

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
                ['height', ['height']]
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
