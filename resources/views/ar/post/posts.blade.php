@extends("ar.layout.main")
@section("content")

    <div id="posts">
        @include("ar.post.post" , ["post" => null])
        @include("ar.post.post" , ["post" => null])
        @include("ar.post.post" , ["post" => null])
        @include("ar.post.post" , ["post" => null])
        @include("ar.post.post" , ["post" => null])
        @include("ar.post.post" , ["post" => null])
    </div>


@endsection