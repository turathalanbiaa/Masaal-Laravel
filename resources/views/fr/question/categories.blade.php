@extends("fr.layout.main")

@section("content")

    <div class="ui green segment">

        <h3 class="ui large left aligned header">العقائد:</h3>
        <div class="ui stackable grid">

            @include("fr.question.category_card" , ["id" => 1 , "image" => "/img/blue.png" , "title" => "التوحيد"])
            @include("fr.question.category_card" , ["id" => 2 , "image" => "/img/blue.png" , "title" => "العدل"])
            @include("fr.question.category_card" , ["id" => 3 , "image" => "/img/blue.png" , "title" => "النبوّة"])
            @include("fr.question.category_card" , ["id" => 4 , "image" => "/img/blue.png" , "title" => "الامامة"])
            @include("fr.question.category_card" , ["id" => 5 , "image" => "/img/blue.png" , "title" => "المعاد"])

        </div>

        <h3 class="ui large left aligned header">الفقه:</h3>
        <div class="ui stackable grid">

            @include("fr.question.category_card" , ["id" => 6 , "image" => "/img/blue.png" , "title" => "الصوم"])
            @include("fr.question.category_card" , ["id" => 7 , "image" => "/img/blue.png" , "title" => "الصلاة"])
            @include("fr.question.category_card" , ["id" => 8 , "image" => "/img/blue.png" , "title" => "الزكاة"])
            @include("fr.question.category_card" , ["id" => 9 , "image" => "/img/blue.png" , "title" => "الحج"])
            @include("fr.question.category_card" , ["id" => 10 , "image" => "/img/blue.png" , "title" => "الخمس"])
            @include("fr.question.category_card" , ["id" => 11 , "image" => "/img/blue.png" , "title" => "الامر بالمعروف"])
            @include("fr.question.category_card" , ["id" => 12 , "image" => "/img/blue.png" , "title" => "النهي عن المنكر"])
            @include("fr.question.category_card" , ["id" => 13 , "image" => "/img/blue.png" , "title" => "التولي لأولياء الله"])
            @include("fr.question.category_card" , ["id" => 14 , "image" => "/img/blue.png" , "title" => "التبري من اعداء الله"])

        </div>

    </div>

@endsection