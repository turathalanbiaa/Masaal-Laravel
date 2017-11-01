@extends("ar.layout.main")



@section("content")

    @if(isset($announcement))
        @include("ar.other.announcement" , ["announcement" => $announcement])
    @endif

    <div id="questions">
        @include("ar.question.question" , ["question" => null])
        @include("ar.question.question" , ["question" => null])
        @include("ar.question.question" , ["question" => null])
        @include("ar.question.question" , ["question" => null])
    </div>


@endsection