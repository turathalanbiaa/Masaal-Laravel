@extends("en.layout.main")

@section("content")

    <div class="ui green segment">
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
        @include("en.question.q_a_section" , ["item" => null])
    </div>

@endsection