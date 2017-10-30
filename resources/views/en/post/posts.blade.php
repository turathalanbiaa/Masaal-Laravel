@extends("en.layout.main")

@section("content")

    <div id="posts">
        @include("en.post.post" , ["post" => null])
        @include("en.post.post" , ["post" => null])
        @include("en.post.post" , ["post" => null])
        @include("en.post.post" , ["post" => null])
        @include("en.post.post" , ["post" => null])
        @include("en.post.post" , ["post" => null])
    </div>


@endsection