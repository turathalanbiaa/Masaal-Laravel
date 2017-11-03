@extends("fr.layout.main")

@section("content")

    <div id="posts">
        @include("fr.post.post" , ["post" => null])
        @include("fr.post.post" , ["post" => null])
        @include("fr.post.post" , ["post" => null])
        @include("fr.post.post" , ["post" => null])
        @include("fr.post.post" , ["post" => null])
        @include("fr.post.post" , ["post" => null])
    </div>


@endsection