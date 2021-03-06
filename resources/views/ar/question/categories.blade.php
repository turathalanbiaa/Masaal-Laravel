@extends("ar.layout.main")
@section("content")

    <div class="ui green segment">

        <h3 class="ui large right aligned header">الفقه:</h3>
        <div class="ui stackable grid">
            @foreach($first_categorys as $first_category)
                @include("ar.question.category_card" , ["id" => $first_category->id ,"type" => $first_category->type, "title" => $first_category->category])
            @endforeach
        </div>

        <h3 class="ui large right aligned header">العقائد:</h3>
        <div class="ui stackable grid">
            @foreach($second_categorys as $second_category)
                @include("ar.question.category_card" , ["id" => $second_category->id , "type" => $second_category->type,"title" => $second_category->category])
            @endforeach
        </div>
        <h3 class="ui large right aligned header">القرآن الكريم:</h3>
        <div class="ui stackable grid">
            @foreach($third_categorys as $third_category)
                @include("ar.question.category_card" , ["id" => $third_category->id , "type" => $third_category->type,"title" => $third_category->category])
            @endforeach
        </div>
        <h3 class="ui large right aligned header">اجتماعية:</h3>
        <div class="ui stackable grid">
            @foreach($fourth_categorys as $fourth_category)
                @include("ar.question.category_card" , ["id" => $fourth_category->id , "type" => $fourth_category->type,"title" => $fourth_category->category])
            @endforeach
        </div>

    </div>
@endsection