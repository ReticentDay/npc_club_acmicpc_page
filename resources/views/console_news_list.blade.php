@extends('layouts.app')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                ranking
                <a role="button" class="btn btn-success btn-xs" href="console/add_news" style="float:right">
                    <samp class="glyphicon glyphicon-plus" aria-hidden="true">Add News</samp>
                </a>
            </div>
            <div class="panel-body">
                <ul>
                @foreach ($newsList as $post)
                    <li>{{ $post->title }}</li>
                @endforeach
                </ul>
                {!! $newsList->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection
