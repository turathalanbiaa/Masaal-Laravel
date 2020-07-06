@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>{{$post->title}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item active" href="/control-panel/posts">
                    <i class="newspaper big icon" style="margin: 0;"></i>&nbsp;
                    <span>المنشورات</span>
                </a>
                <a class="item" href="/control-panel/posts/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة منشور</span>
                </a>
            </div>
        </div>

        <div class="column">
            <div class="ui green right aligned segment" style="min-height: 500px;">
                <h3 class="ui medium teal header">
                    {{$post->title}}
                </h3>
                @if(!is_null($post->image))
                    <img class="ui left floated image" src="{{asset("storage/".$post->image)}}">
                @endif
                <p>
                    {{$post->content}}
                </p>
            </div>
        </div>
    </div>
@endsection