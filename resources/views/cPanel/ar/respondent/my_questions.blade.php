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

        <div class="ui right aligned segments">
            @if(count($questions) > 0)
            @foreach($questions as $question)
            <div class="ui teal segment">
                <div class="ui dimmer" id="dimmer">
                    <div class="ui text loader">جاري التحميل...</div>
                </div>

                <p><span style="color: #21ba45;">السؤال:-</span> {{$question->content}}</p>
                <div class="ui hidden divider"></div>
                <a class="ui green button" href="/control-panel/{{$lang}}/question?id={{$question->id}}">اجابة السؤال</a>

                <button class="ui left floated red button" data-token="{!! csrf_token() !!}" data-question-id="{{$question->id}}" data-action="change-question-type">
                @if($question->type == \App\Enums\QuestionType::FEQHI)
                    {{"تحويل الى العقائد"}}
                @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                    {{"تحويل الى الفقه"}}
                @endif
                </button>
            </div>
            @endforeach

            <div class="ui bottom teal segment">
                {{$questions->links()}}
            </div>
            @else
            <div class="ui massive info message">
                <div class="ui hidden divider"></div>
                <div class="ui hidden divider"></div>
                <div class="ui center aligned header">لاتوجد اسئلة جديدة</div>
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
    $('.pagination').addClass('ui right aligned pagination menu');
    $('.pagination').css({'padding':'0','font-size':'15px'});
    $('.pagination').find('li').addClass('item');

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