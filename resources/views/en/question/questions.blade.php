@extends("en.layout.main")



@section("content")

    @if(isset($announcement))
        @include("en.other.announcement" , ["announcement" => $announcement])
    @endif

    <div id="questions">
        @include("en.question.question" , ["question" => null])
        @include("en.question.question" , ["question" => null])
        @include("en.question.question" , ["question" => null])
        @include("en.question.question" , ["question" => null])
    </div>


@endsection