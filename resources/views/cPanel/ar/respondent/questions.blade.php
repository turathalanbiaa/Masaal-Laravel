@extends("cPanel.ar.layout.main_layout")

@section("title")
<title>اسئلتي</title>
@endsection

@section("content")
<div class="ui one column grid">
    <div class="column">
        @include("cPanel.ar.layout.welcome")
    </div>

    <div class="column">
        <div class="ui three item teal big menu">
            <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
            <a class="item active" href="/control-panel/{{$lang}}/my-questions">اسئلتي</a>
            <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
        </div>
    </div>

    @if(session("QuestionMessage"))
        <div class="column">
            <div class="ui info message">
                <h2 style="text-align: center;">{{session("QuestionMessage")}}</h2>
            </div>
        </div>
    @endif

    <div class="column">
        <div class="ui right aligned segments">
            @if(count($questions) > 0)
                @foreach($questions as $question)
                    <div class="ui teal segment">
                        <div class="ui dimmer" id="dimmer">
                            <div class="ui text loader">جاري التحميل...</div>
                        </div>

                        <p><span style="color: #21ba45;">السؤال:-</span> {{$question->content}}</p>

                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>

                        <a class="ui green button" href="/control-panel/{{$lang}}/question?id={{$question->id}}">اجابة السؤال</a>

                        <button class="ui left floated red button" data-question-id="{{$question->id}}" data-action="change-question-type">
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

    $("button[data-action='change-question-type']").click(function () {
        var button = $(this);
        var questionId = button.data('question-id');
        var _token = "{{csrf_token()}}";
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
                var segment = button.parent();
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