@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>توزيع الاسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item active" href="/control-panel/distributors">
                    <i class="recycle big icon" style="margin: 0;"></i> &nbsp;
                    <span>توزيع الاسئلة</span>
                </a>
                <a class="item" href="/control-panel/logout">
                    <i class="shutdown big icon" style="margin: 0;"></i>&nbsp;
                    <span>تسجيل خروج</span>
                </a>
            </div>
        </div>

        @if(session("ArDeleteQuestionMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}}  message">
                    <h2 class="ui center aligned header">{{session("ArDeleteQuestionMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArChangeTypeQuestionMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}}  message">
                    <h2 class="ui center aligned header">{{session("ArChangeTypeQuestionMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segments">
                @forelse($questions as $question)
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
                            <input type="hidden" name="questionId" value="{{$question->id}}">
                            <div class="sixteen wide field">
                                <div class="ui selection dropdown" style="width: 100%;">
                                    <input type="hidden" name="respondentId">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">أختر اسم المجيب</div>
                                    <div class="menu">
                                        @foreach($respondents as $respondent)
                                            <div class="item" data-value="{{$respondent->id}}">
                                                {{$respondent->name}}
                                                <div class="ui label">
                                                    <div class="detail" style="margin: 0;">{{$respondent->unansweredQuestions()->count()}}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="sixteen wide field">
                                <button class="ui green button" data-action="distribute-question">تحويل</button>
                                <button class="ui red button" data-action="delete-question" data-value="{{$question->id}}">حذف</button>

                                <button class="ui left floated orange button" data-action="change-type-question" data-value="{{$question->id}}">
                                    @if($question->type == \App\Enums\QuestionType::FEQHI)
                                        {{"تحويل الى العقائد"}}
                                    @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                                        {{"تحويل الى الفقه"}}
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
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
                @endforelse

                @if($questions->hasPages())
                    <div class="ui bottom teal center aligned inverted segment">
                        {{$questions->links()}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal" id="model-delete-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف السؤال !!!</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-question').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form id="form-delete-question" method="post" action="/control-panel/distributors/delete-question">
        @csrf()
        <input type="hidden" name="question" value="">
    </form>
    <div class="ui mini modal" id="model-change-type-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من تغيير نوع السؤال !!!</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-change-type-question').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form id="form-change-type-question" method="post" action="/control-panel/distributors/change-type-question">
        @csrf()
        <input type="hidden" name="question" value="">
    </form>
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

            var questionId = button.parent().parent().find("input[type='hidden'][name='questionId']").val();
            var respondentId = button.parent().parent().find("input[type='hidden'][name='respondentId']").val();

            var currentDimmer = button.parent().parent().parent().find('#dimmer');
            currentDimmer.addClass("active");

            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/control-panel/distributors/distribute-question',
                data: {questionId:questionId, respondentId:respondentId},
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
                        //Hidden segment
                        setTimeout(function(){
                            var segment = button.parent().parent().parent();
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);

                        //Increment unanswered question counter
                        var count = $("div[data-value='" + respondentId + "']").find(".detail").html();
                        $("div[data-value='" + respondentId + "']").find(".detail").html(++count);
                    }
                }
            });
        });

        $("button[data-action='delete-question']").click(function () {
            $("#model-delete-question")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            $("#form-delete-question>[name='question']").val($(this).data("value"));
        });

        $("button[data-action='change-type-question']").click(function () {
            $("#model-change-type-question")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            $("#form-change-type-question>[name='question']").val($(this).data("value"));
        });

        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection