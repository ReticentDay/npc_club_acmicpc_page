@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    NewsList &nbsp;

                    @can('check_admin')
                    <a role="button" class="btn btn-success btn-xs" href="news/add_news" style="float:right">
                        <samp class="glyphicon glyphicon-plus" aria-hidden="true">Add News</samp>
                    </a>
                    @endcan
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped">
                        <tr>
                            <th>
                                <div class="text-center">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a role="button" class="btn btn-default btn-md" href="/news">all</a>
                                        <a role="button" class="btn btn-default btn-md" href="/news/?find_type=system">system</a>
                                        <a role="button" class="btn btn-default btn-md" href="/news/?find_type=comprition">comprition</a>
                                        <a role="button" class="btn btn-default btn-md" href="/news/?find_type=event">event</a>
                                        <a role="button" class="btn btn-default btn-md" href="/news/?find_type=other">other</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @foreach ($newsList as $post)
                            <tr>
                                <td>
                                    <div class="col-md-1 col-sm-1 col-xs-1"><span class="label label-primary">{{ $post->type }}</span></div>

                                    @can('check_admin')
                                        <div class="col-md-9 col-sm-9 col-xs-9"><a href="/news/show?id={{ $post->id }}">{{ $post->title }}</a></div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <form action="/news/delete" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $post->id }}">
                                                <div class="text-right"><input type="submit" class="btn btn-danger btn-xs" name="submit" value="delete"></div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-md-11 col-sm-11 col-xs-11"><a href="/news/show?id={{ $post->id }}">{{ $post->title }}</a></div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="text-center">
                        {!! $newsList->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
