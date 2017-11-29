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
                            <div class="ui dimmer" id="dimmer">
                                <div class="ui text loader">جاري التحميل...</div>
                            </div>
                            <p class="ui green header">السؤال:-</p>
                            <p>{{$question->content}}</p>
                            <div class="ui divider"></div>
                            <div class="ui form">
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
                                    <button class="ui green button" data-action="distribute-question">ارسال</button>
                                    <button class="ui left floated red button" data-token="{!! csrf_token() !!}" data-question-id="{{$question->id}}" data-action="change-question-type">
                                        @if($question->type == \App\Enums\QuestionType::FEQHI)
                                            {{"تحويل الى العقائد"}}
                                        @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                                            {{"تحويل الى الفقه"}}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="ui bottom teal segment">
                        {{$questions->links()}}
                    </div>
                @else
                    <div class="ui massive info message">
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                        <div class="ui center aligned header">لاتوجد اسئلة جديدة لعرضها</div>
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

        $("button[data-action='distribute-question']").click(function ()
        {
            var _token = $(this).parent().parent().find("input[type='hidden'][name='_token']").val();
            var questionId = $(this).parent().parent().find("input[type='hidden'][name='questionId']").val();
            var respondentId = $(this).parent().parent().find("input[type='hidden'][name='respondentId']").val();
            $(this).parent().parent().parent().find('#dimmer').addClass("active");

            $.ajax({
                type: "POST",
                url: '/control-panel/distribution',
                data: {_token:_token, questionId:questionId, respondentId:respondentId},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if(result["respondent"] == "NotFound")
                        snackbar("لم يتم اختيار المجيب." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم تحويل السؤال الى المجيب !!، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] == true)
                        snackbar("تم تحويل السؤال الى المجيب بنجاح." , 3000 , "success");
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    $('#dimmer').removeClass("active");
                }
            });
        });

        $("button[data-action='change-question-type']").click(function ()
        {
            var questionId = $(this).data('question-id');
            var _token = $(this).data('token');
            var button = $(this);
            button.addClass("loading");

            $.ajax({
                type: "POST",
                url: '/control-panel/change-question-type',
                data: {questionId:questionId, _token:_token},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم تحويل نوع السؤال." , 3000 , "error");

                    else if (result["success"] == true)
                        snackbar("تم تجويل نوع السؤال." , 3000 , "success");
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    button.removeClass("loading");
                    var segment = button.parent().parent().parent();
                    segment.addClass("scale");
                    segment.transition({
                        animation  : 'scale',
                        duration   : '1s'
                    });
                }
            });
        });
    </script>
@endsection