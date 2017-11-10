@extends("ar.layout.main")



@section("content")

    @if(isset($announcements))
        @include("ar.other.announcement" , ["announcements" => $announcements])
    @endif
    @foreach($questions as $question)
    <div id="questions">
        @include("ar.question.question" , ["question" => $question])

    </div>
    @endforeach

@endsection