@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">news</div>

                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            @foreach($newsList as $news)
                            <tr>
                                <td>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $news->type }}</span></div>
                                    <div class="col-md-10 col-sm-10 col-xs-10"><a href="/news/show/?id={{ $news->id }}">{{ $news->title }}</a></div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">competition</div>

                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            @foreach($comprtitionList as $comprtition)
                            <tr>
                                <td>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $comprtition->type }}</span></div>
                                    <div class="col-md-10 col-sm-10 col-xs-10"><a href="/comprtition/{{ $comprtition->id }}">{{ $comprtition->title }}</a></div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">ranking</div>

                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            @foreach($CCoinTable as $CCoin)
                            <tr>
                                <td>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-left">{{ $CCoin->name }}</div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">{{ $CCoin->sum }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
