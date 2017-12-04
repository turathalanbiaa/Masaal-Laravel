@extends("ar.layout.main")

@section("content")

    <div class="ui green segment">
        <div style="direction: ltr" class="column">
            <div class="ui teal left ribbon label">التقسيم حسب المواظيع</div>

        </div>
        @include("ar.question.q_a_section" , ["tags" => $tags])

    </div>
    
@endsection