@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    community List &nbsp;

                    @if (Auth::check())
                    <a role="button" class="btn btn-success btn-xs" href="/community/create" style="float:right">
                        <samp class="glyphicon glyphicon-plus" aria-hidden="true">Add article</samp>
                    </a>
                    @endif
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped">
                        <tr>
                            <th>
                                <div class="text-center">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a role="button" class="btn btn-default btn-md" href="/community">all</a>
                                        <a role="button" class="btn btn-default btn-md" href="/community/comprition/search/">comprition</a>
                                        <a role="button" class="btn btn-default btn-md" href="/community/question/search/">question</a>
                                        <a role="button" class="btn btn-default btn-md" href="/community/system/search/">system</a>
                                        <a role="button" class="btn btn-default btn-md" href="/community/other/search/">other</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @foreach ($communityTable as $post)
                            <tr>
                                <td>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $post->type }}</span></div>

                                    @can('check_root')
                                        <div class="col-md-6 col-sm-6 col-xs-6"><span id="reply_{{ $post->id }}" class="badge"></span><a href="/community/{{ $post->id }}">【 {{ $post->association }} 】{{ $post->title }}</a></div>
                                        <div class="col-md-2 col-sm-2 col-xs-2"><span id="like_{{ $post->id }}" class=""></span> {{ $post->creat_user }}</div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <form action="/community/{{ $post->id }}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $post->id }}">
                                                <div class="text-right"><input type="submit" class="btn btn-danger btn-xs" name="submit" value="delete"></div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-md-8 col-sm-8 col-xs-8"><span id="reply_{{ $post->id }}" class="badge"></span><a href="/community/{{ $post->id }}">【 {{ $post->association }} 】{{ $post->title }}</a></div>
                                        <div class="col-md-2 col-sm-2 col-xs-2"><span id="like_{{ $post->id }}" class=""></span> {{ $post->creat_user }}</div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="text-center">
                        {!! $communityTable->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $content = JSON.parse('{!! $communityJson !!}');
        for (var put in $content.community) {
            $('#like_' + $content.community[put].id).append($content.community[put].count);
            if($content.community[put].count > 50)
                $('#like_' + $content.community[put].id).attr("class","label label-danger");
            else if($content.community[put].count > 30)
                $('#like_' + $content.community[put].id).attr("class","label label-warning");
            else if($content.community[put].count > 10)
                $('#like_' + $content.community[put].id).attr("class","label label-success");
            else
                $('#like_' + $content.community[put].id).attr("class","label label-default");
            $('#reply_' + $content.community[put].id).append($content.community[put].reply);
        }
    });
</script>
@endsection
