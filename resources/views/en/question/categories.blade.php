@extends("en.layout.main")
@section("content")

    <div class="ui green segment">

        <h3 class="ui large right aligned header">Jurisprudential
            :</h3>
        <div class="ui stackable grid">
            @foreach($first_categorys as $first_category)
                @include("en.question.category_card" , ["id" => $first_category->id ,"type" => $first_category->type, "title" => $first_category->category])
            @endforeach
        </div>

        <h3 class="ui large right aligned header">Ideological
            :</h3>
        <div class="ui stackable grid">
            @foreach($second_categorys as $second_category)
                @include("en.question.category_card" , ["id" => $second_category->id , "type" => $first_category->type,"title" => $second_category->category])
            @endforeach
        </div>

    </div>
@endsection