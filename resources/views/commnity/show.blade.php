@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/community">Community</a></li>
                <li>{{ $communityTable->title }}</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2 text-center"><span class="label label-primary">{{ $communityTable->type }}</span></div>
                        <div class="col-md-8 col-sm-8 col-xs-8">【 {{ $communityTable->association }} 】{{ $communityTable->title }}</div>
                        @can('updateName' , $communityTable)
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <a role="button" class="btn btn-success btn-xs" href="/community/{{ $communityTable->id }}/edit" style="float:right">
                                    <samp class="glyphicon glyphicon-pencil" aria-hidden="true">edit article</samp>
                                </a>
                            </div>
                        @else
                            <div class="col-md-2 col-sm-2 col-xs-2 text-center">
                                Author:{{ $communityTable->creat_user }}
                            </div>
                        @endcan
                    </div>

                </div>
                <div class="panel-body">
                    <b>creat time : </b>{{ $communityTable->created_at }} &nbsp;
                    <b>updated time : </b>{{ $communityTable->updated_at }}
                    <hr>
                    {!! $communityTable->content !!}
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-xs-9">
                                    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    @if (Auth::check())
                                        <form action="/community/{{ $communityTable->id }}/like" method="post">
                                            @if($communityGoodHas > 0)
                                                <fieldset disabled>
                                            @endif
                                            {!! csrf_field() !!}
                                            <input class="btn btn-xs btn-success btn-block" type="submit" name="" value="❤Like【{{ $communityGood }}】">
                                            @if($communityGoodHas > 0)
                                                </fieldset>
                                            @endif
                                        </form>
                                    @else
                                        <b>❤Like【{{ $communityGood }}】</b>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-hover table-striped">
                        <tr><th>Reply:</th></tr>
                        @foreach($communityReplyList as $post)
                            <tr>
                                <td>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        {{ $post->creat_user }}
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        {{ $post->content }}
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        {{ $post->created_at }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @if (Auth::check())
                        <form class="" action="/community/{{ $communityTable->id }}/reply" method="post">
                            {!! csrf_field() !!}
                            <div class="col-md-10 col-sm-10 col-xs-10"><input type="text" class="form-control" name="content" value="" placeholder="reply"></div>
                            <div class="col-md-2 col-sm-2 col-xs-2"><input type="submit" class="btn btn-success btn-block" name="" value="submit"></div>
                        </form>
                        <br>
                    @endif

                    <hr>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '125497494693521',
      xfbml      : true,
      version    : 'v2.10'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@endsection
