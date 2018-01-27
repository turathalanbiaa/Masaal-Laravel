@extends("en.layout.main")

@section("content")

    <div id="posts">
        @foreach($posts as $post)

            @foreach($post as $en_post)
                @include("en.post.post" , ["post" => $en_post])
            @endforeach

        @endforeach

    </div>


@endsection