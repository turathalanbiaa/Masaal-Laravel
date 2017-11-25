@extends("ar.layout.main")

@section("content")

    <div class="ui green segment">
        @include("ar.question.q_a_section" , ["tags" => $tags])
        
    </div>
    
@endsection