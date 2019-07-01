@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>التقارير</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui two column grid">
                <div class="column">
                    @php $privacy = 1; @endphp
                    <div class="ui center aligned segment">
                        <h1 class="ui center aligned green header">التقارير العامة</h1>
                        <div>
                            <h3 class="ui brown header">تقارير الفقه</h3>
                            @foreach($fCategories as $category)
                                <a href="/control-panel/report/{{\App\Enums\QuestionType::FEQHI}}/{{$privacy}}/{{$category->id}}" class="ui button" style="margin: 20px 10px;">{{$category->category}}</a>
                            @endforeach

                            <a href="/control-panel/report/{{\App\Enums\QuestionType::FEQHI}}/{{$privacy}}/0" class="ui button" style="margin: 20px 10px;">بدون قسم</a>
                        </div>

                        <div class="ui divider"></div>
                        <div class="ui divider"></div>

                        <div>
                            <h3 class="ui brown header">تقارير العقائد</h3>
                            @foreach($aCategories as $category)
                                <a href="/control-panel/report/{{\App\Enums\QuestionType::AKAEDI}}/{{$privacy}}/{{$category->id}}" class="ui button" style="margin: 20px 10px;">{{$category->category}}</a>
                            @endforeach

                            <a href="/control-panel/report/{{\App\Enums\QuestionType::AKAEDI}}/{{$privacy}}/0" class="ui button" style="margin: 20px 10px;">بدون قسم</a>
                        </div>
                    </div>
                </div>

                <div class="column">
                    @php $privacy = 2; @endphp
                    <div class="ui center aligned segment">
                        <h1 class="ui center aligned green header">التقارير الخاصة</h1>
                        <div>
                            <h3 class="ui brown header">تقارير الفقه</h3>
                            @foreach($fCategories as $category)
                                <a href="/control-panel/report/{{\App\Enums\QuestionType::FEQHI}}/{{$privacy}}/{{$category->id}}" class="ui button" style="margin: 20px 10px;">{{$category->category}}</a>
                            @endforeach

                            <a href="/control-panel/report/{{\App\Enums\QuestionType::FEQHI}}/{{$privacy}}/0" class="ui button" style="margin: 20px 10px;">بدون قسم</a>
                        </div>

                        <div class="ui divider"></div>
                        <div class="ui divider"></div>

                        <div>
                            <h3 class="ui brown header">تقارير العقائد</h3>
                            @foreach($aCategories as $category)
                                <a href="/control-panel/report/{{\App\Enums\QuestionType::AKAEDI}}/{{$privacy}}/{{$category->id}}" class="ui button" style="margin: 20px 10px;">{{$category->category}}</a>
                            @endforeach

                            <a href="/control-panel/report/{{\App\Enums\QuestionType::AKAEDI}}/{{$privacy}}/0" class="ui button" style="margin: 20px 10px;">بدون قسم</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection