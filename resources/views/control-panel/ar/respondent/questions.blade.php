@extends("control-panel.ar.layout.main_layout")

@section("title")
<title>اسئلتي</title>
@endsection

@section("content")
<div class="ui one column grid">
    <div class="column">
        @include("control-panel.ar.layout.welcome")
    </div>

    <div class="column">
        <div class="ui four item teal big menu">
            <a class="item" href="/control-panel/{{$lang}}/main">
                <i class="home big icon"></i>&nbsp;
                <span>الرئيسية</span>
            </a>
            <a class="item active" href="/control-panel/{{$lang}}/my-questions">
                <i class="bars big icon"></i>&nbsp;
                <span>اسئلتي</span>
            </a>
            <a class="item" href="">
                <i class="history big icon"></i>&nbsp;
                <span>ارشيف الاسئلة</span>
            </a>
            <a class="item" href="/control-panel/{{$lang}}/logout">
                <i class="shutdown big icon"></i>&nbsp;
                <span>تسجيل خروج</span>
            </a>
        </div>
    </div>

    @if(session("ArInfoMessage"))
        <div class="column">
            <div class="ui info message">
                <h2 class="ui center aligned header">{{session("ArInfoMessage")}}</h2>
            </div>
        </div>
    @endif

    <div class="column">
        <div class="ui right aligned segments">
            @if(count($questions) > 0)
                @foreach($questions as $question)
                    <div class="ui teal segment">
                        <div class="ui dimmer">
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

                        <a class="ui green button" href="/control-panel/{{$lang}}/question?id={{$question->id}}">اجابة السؤال</a>
                        <button class="ui red button" data-action="delete-question" data-question-id="{{$question->id}}">حذف</button>

                        <button class="ui left floated orange button" data-question-id="{{$question->id}}" data-action="change-question-type">
                            @if($question->type == \App\Enums\QuestionType::FEQHI)
                                {{"تحويل الى العقائد"}}
                            @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                                {{"تحويل الى الفقه"}}
                            @endif
                        </button>
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
                        <div class="ui center aligned header">لاتوجد اسئلة جديدة</div>
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
    $(document).ready(function () {
        var pagination = $(".pagination");
        pagination.removeClass("pagination").addClass("ui right aligned pagination teal menu");
        pagination.css("padding","0");
        pagination.find('li').addClass('item');
    });

    $('.ui.info.message').transition({
        animation  : 'flash',
        duration   : '1s'
    });

    $("button[data-action='delete-question']").click(function () {
        var button = $(this);
        var _token = "{!! csrf_token() !!}";
        var questionId = button.data("question-id");
        var currentDimmer = button.parent().find(".dimmer");
        var success = false;
        currentDimmer.addClass("active");

        console.log(_token);
        console.log(questionId);

        $.ajax({
            type: "POST",
            url: '/control-panel/respondent/delete-question',
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
                        var segment = button.parent();
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
                        var segment = button.parent();
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