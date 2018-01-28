@extends("fr.layout.main")
@section("content")

    <div id="posts">


        @foreach($posts as $post)

            @foreach($post as $ar_post)
                @include("fr.post.post" , ["post" => $ar_post])
            @endforeach

        @endforeach


    </div>


@endsection