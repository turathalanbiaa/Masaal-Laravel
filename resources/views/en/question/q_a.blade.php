@extends("en.layout.main")

@section("content")

    <div class="ui green segment">
        <div style="direction: ltr" class="column">
            <div class="ui teal left ribbon label">Group by Subject

            </div>

        </div>
        @include("en.question.q_a_section" , ["tags" => $tags])

    </div>

@endsection