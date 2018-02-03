@extends("fr.layout.main")

@section("content")

    <div class="ui green segment">
        <div style="direction: ltr" class="column">
            <div class="ui teal left ribbon label">groupe par sujet</div>

        </div>
        @include("fr.question.q_a_section" , ["tags" => $tags])

    </div>

@endsection