@extends("fr.layout.main")



@section("content")

    @if(isset($announcement))
        @include("fr.other.announcement" , ["announcement" => $announcement])
    @endif

    <div id="questions">
        @include("fr.question.question" , ["question" => null])
        @include("fr.question.question" , ["question" => null])
        @include("fr.question.question" , ["question" => null])
        @include("fr.question.question" , ["question" => null])
    </div>


@endsection