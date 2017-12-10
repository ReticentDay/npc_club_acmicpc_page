@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Competition List &nbsp;

                    @can('check_admin')
                    <a role="button" class="btn btn-success btn-xs" href="comprtition/create" style="float:right">
                        <samp class="glyphicon glyphicon-plus" aria-hidden="true">Add Compeition</samp>
                    </a>
                    @endcan
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped">
                        @foreach ($comprtitionList as $post)
                            <tr>
                                <td>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><span class="label label-primary">{{ $post->type }}</span></div>

                                    @can('check_root')
                                        <div class="col-md-8 col-sm-8 col-xs-8"><a href="/comprtition/{{ $post->id }}">{{ $post->title }}</a></div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <form action="/comprtition/{{ $post->id }}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $post->id }}">
                                                <div class="text-right"><input type="submit" class="btn btn-danger btn-xs" name="submit" value="delete"></div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-md-10 col-sm-10 col-xs-10"><a href="/comprtition/{{ $post->id }}">{{ $post->title }}</a></div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="text-center">
                        {!! $comprtitionList->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
