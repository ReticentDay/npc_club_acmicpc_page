@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>

                <div class="panel-body">
                    {{ $message }} </br>
                    <p class="text-right"><a href="/{{ $link }}">Check me go back to {{ $where }}→</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
