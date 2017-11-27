@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>توزيع الاسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">

            <div class="ui right aligned segments">
                @if(count($questions) > 0)
                    @foreach($questions as $question)
                        <div class="ui teal segment">
                            <p class="ui green header">السؤال:-</p>
                            <p>{{$question->content}}</p>
                            <div class="ui divider"></div>
                            <form class="ui form" method="post" action="/control-panel/{{$lang}}/distribution">
                                {!! csrf_field() !!}
                                <input type="hidden" name="questionId" value="{{$question->id}}">
                                <div class="sixteen wide field">
                                    <div class="ui selection dropdown" style="width: 100%;">
                                        <input type="hidden" name="respondentId">
                                        <i class="dropdown icon"></i>
                                        <div class="default text">أختر اسم المجيب</div>
                                        <div class="menu">
                                            @foreach($respondents as $respondent)
                                                <div class="item" data-value="{{$respondent->id}}">{{$respondent->name}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="sixteen wide field">
                                    <button class="ui green button" type="submit">ارسال</button>
                                    <button class="ui left floated red button"  data-questionId="{{$question->id}}" data-action="convert-type-question">
                                        @if($question->type == \App\Enums\QuestionType::FEQHI)
                                            {{"تحويل الى اسئلة العقائد"}}
                                        @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                                            {{"تحويل الى اسئلة الفقه"}}
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="ui bottom teal segment">
                        {{$questions->links()}}
                    </div>
                @else
                    <div class="ui massive info message">
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                        <div class="ui celled aligned header">لاتوجد اسئلة جديدة لعرضها</div>
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $(".ui.selection.dropdown").dropdown();
        $('.pagination').addClass('ui right aligned pagination menu');
        $('.pagination').css({'padding':'0','font-size':'15px'});
        $('.pagination').find('li').addClass('item');
        $('.ui.form').form({
            fields: {
                respondentId: {rules: [{type   : 'empty'}]}
            }
        });
    </script>
@endsection