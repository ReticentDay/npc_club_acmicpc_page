@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/news">News</a></li>
                <li>{{ $News->title }}</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{ $News->title }}</h2>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12"><p><span class="label label-info">{{ $News->type }}</span>  creat time：{{ $News->created_at }}</p></div>
                        <div class="col-md-6 col-sm-12 col-xs-12"><div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div></div>
                    </div>
                </div>
                <div class="panel-body">
                    {!! $News->content !!}
                    
                    <p class="text-right"><a href="/news">Check me go back to news→</a></p>
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