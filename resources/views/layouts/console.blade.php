@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a role="button" class="btn btn-primary btn-block" href="console/">Index</a>
                            <a role="button" class="btn btn-primary btn-block" href="console/news">Add News</a>
                            <a role="button" class="btn btn-primary btn-block">Add competition</a>
                            <a role="button" class="btn btn-primary btn-block">Add CC coin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('console')
    </div>
</div>
@endsection
