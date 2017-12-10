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
                    Do you want to join it?
                </div>
                <div class="panel-body">
                    <form class="" action="/comprtition/{{ $comprtitionConent->id }}/add" method="post">
                        {!! csrf_field() !!}
                        <div class="col-md-4 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-2">
                            <input class="btn btn-success btn-block" type="submit" name="" value="Yes">
                            <a role="button"  class="btn btn-danger btn-block" href="/comprtition">No</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
