@extends("fr.layout.main")

@section("content")

    <div class="ui green segment">
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
        @include("fr.question.q_a_section" , ["item" => null])
    </div>

@endsection