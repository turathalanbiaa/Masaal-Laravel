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
            <div class="ui three item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/distribution-questions">توزيع الاسئلة</a>
                <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
            </div>
        </div>

        <div class="column">
            <div class="ui right aligned segments">
                @if(count($questions) > 0)
                    @foreach($questions as $question)
                        <div class="ui teal segment">
                            <div class="ui dimmer" id="dimmer">
                                <div class="ui text loader">جاري التحميل...</div>
                            </div>

                            <p style="font-weight: bold;">
                                <span>اسم السائل</span>
                                <span> :- </span>
                                <span style="color: #00b5ad;">{{$question->User["name"]}}</span>
                            </p>

                            <p>
                                <span style="color: #21ba45;">السؤال :- </span>
                                <span>{{$question->content}}</span>
                            </p>
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
                                    <button class="ui green button" data-action="distribute-question">تحويل</button>
                                    <button class="ui red button" data-action="delete-question">حذف</button>

                                    <button class="ui left floated orange button" data-question-id="{{$question->id}}" data-action="change-question-type">
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

                    @if($questions->hasPages())
                        <div class="ui bottom teal center aligned inverted segment">
                            {{$questions->links()}}
                        </div>
                    @endif

                @else
                    <div class="ui segment">
                        <div class="ui massive info message">
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui center aligned header">لاتوجد اسئلة جديدة لتوزيعها</div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $(".ui.selection.dropdown").dropdown();

        $(document).ready(function () {
            var pagination = $(".pagination");
            pagination.removeClass("pagination").addClass("ui right aligned pagination teal menu");
            pagination.css("padding","0");
            pagination.find('li').addClass('item');
        });

        $("button[data-action='distribute-question']").click(function () {
            var button = $(this);
            var _token = button.parent().parent().find("input[type='hidden'][name='_token']").val();
            var questionId = button.parent().parent().find("input[type='hidden'][name='questionId']").val();
            var respondentId = button.parent().parent().find("input[type='hidden'][name='respondentId']").val();
            var currentDimmer = button.parent().parent().parent().find('#dimmer');
            var success = false;
            currentDimmer.addClass("active");

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
                    {
                        snackbar("تم تحويل السؤال الى المجيب بنجاح." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    currentDimmer.removeClass("active");

                    if(success)
                    {
                        setTimeout(function(){
                            var segment = button.parent().parent().parent();
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });

        $("button[data-action='delete-question']").click(function () {
            var button = $(this);
            var _token = button.parent().parent().find("input[type='hidden'][name='_token']").val();
            var questionId = button.parent().parent().find("input[type='hidden'][name='questionId']").val();
            var currentDimmer = button.parent().parent().parent().find('#dimmer');
            var success = false;
            currentDimmer.addClass("active");

            $.ajax({
                type: "POST",
                url: '/control-panel/distributor/delete-question',
                data: {_token:_token, questionId:questionId},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم حذف السؤال !!، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] == true)
                    {
                        snackbar("تم حذف السؤال بنجاح." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    currentDimmer.removeClass("active");

                    if(success)
                    {
                        setTimeout(function(){
                            var segment = button.parent().parent().parent();
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });

        $("button[data-action='change-question-type']").click(function () {
            var button = $(this);
            var _token = "{{csrf_token()}}";
            var questionId = button.data('question-id');
            var dimmer = button.parent().find(".dimmer");
            var success = false;
            dimmer.addClass("active");

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
                    {
                        snackbar("تم تحويل نوع السؤال." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    dimmer.removeClass("active");
                    if (success)
                    {
                        setTimeout(function () {
                            var segment = button.parent().parent().parent();
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });
    </script>
@endsection