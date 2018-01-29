@extends("ar.layout.main")
@section("content")

    <div id="posts">



            @foreach($posts as $ar_post)
                @include("ar.post.post" , ["post" => $ar_post])
            @endforeach



            @if(isset($unlink))

            @else
                {!! $posts->links() !!}

            @endif
    </div>


@endsection