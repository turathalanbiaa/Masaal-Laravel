@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>مراجعة الأسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui two item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item active" href="/control-panel/reviewer">
                    <i class="eye big icon" style="margin: 0;"></i>&nbsp;
                    <span>مراجعة الاسئلة</span>
                </a>
            </div>
        </div>

        @if(session("ArUpdateAnswerMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArUpdateAnswerMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segments">
                @forelse($questions as $question)
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

                        <p>
                            <span style="color: #b5cc18;">الجواب :- </span>
                            <span>{{$question->answer}}</span>
                        </p>

                        <div class="ui accordion">
                            <div class="title">
                                <i class="dropdown icon"></i>
                                <span>تفاصيل أكثر</span>
                            </div>
                            <div class="content">
                                <p>
                                    <span>المجيب</span>
                                    <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                    <span>{{$question->Admin["name"]}}</span>
                                </p>

                                <p>
                                    <span>صنف السؤال</span>
                                    <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(is_null($question->Category))
                                        <span>لا يوجد صنف للسؤال.</span>
                                    @else
                                        <span>{{$question->Category->category}}</span>
                                    @endif
                                </p>

                                <p>
                                    <span>الكلمات الدلالية</span>
                                    <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                    @forelse($question->QuestionTags as $questionTag)
                                        <span>{{$questionTag->Tag->tag . "،"}}</span>
                                    @empty
                                        <span>لا توجد كلمات دلالية.</span>
                                    @endforelse
                                </p>

                                <p>
                                    <span>رابط الفديو</span>
                                    <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(is_null($question->videoLink))
                                        <span>لايوجد فديو مرفق</span>
                                    @else
                                        <a target="_blank" href="https://www.youtube.com/watch?v={{$question->videoLink}}">https://www.youtube.com/watch?v={{$question->videoLink}}</a>
                                    @endif
                                </p>

                                <p>
                                    <span>رابط المصدر</span>
                                    <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(is_null($question->externalLink))
                                        <span>لايوجد رابط مصدر مرفق</span>
                                    @else
                                        <a target="_blank" href="{{$question->externalLink}}">{{$question->externalLink}}</a>
                                    @endif
                                </p>

                                <div>
                                    <span>الصورة المرفقه</span>
                                    @if(!is_null($question->image))
                                        <i class="long arrow down icon" style="font-size: medium; font-weight: bold;"></i><br>
                                        <div class="ui medium bordered rounded image">
                                            <img src="{{ asset("storage/".$question->image)}}">
                                        </div>
                                    @else
                                        <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                        <span>لاتوجد صورة مرفقه</span>
                                    @endif
                                </div>

                                <div class="ui divider"></div>
                            </div>
                        </div>

                        <div class="ui hidden divider"></div>

                        <button class="ui inverted green button" data-action="accept-answer" data-content="{{$question->id}}">قبول الاجابة</button>
                        <button class="ui inverted orange button" data-action="reject-answer" data-content="{{$question->id}}">رفض الاجابة</button>
                        <a class="ui inverted blue button" href="/control-panel/reviewer/{{$question->id}}/edit">تعديل الاجابة</a>
                        <button class="ui inverted red button" data-action="delete-question" data-content="{{$question->id}}">حذف السؤال</button>
                    </div>
                @empty
                    <div class="ui segment">
                        <div class="ui massive info message">
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui center aligned header">لاتوجد اسئلة جديدة لمراجعتها</div>
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
    <div class="ui mini modal" id="modal-accept-answer">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من قبول الاجابة؟</span>
        </h3>
        <div class="content">
            <input type="hidden" name="question">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>

    <div class="ui mini modal" id="modal-reject-answer">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من رفض الاجابة؟</span>
        </h3>
        <div class="content">
            <input type="hidden" name="question">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>

    <div class="ui mini modal" id="modal-delete-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف السؤال؟</span>
        </h3>
        <div class="content">
            <input type="hidden" name="question">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button">نعم</button>
                <button class="ui negative button">لا</button>
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
        $('.ui.accordion').accordion();
        $('.ui.embed').embed();
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });

        //Accept answer
        $("button[data-action='accept-answer']").click(function () {
            var button = $(this);
            button.parent().attr("id", "current-segment");
            button.addClass("loading");
            $("#modal-accept-answer input[name='question']").val(button.data("content"));
            $("#modal-accept-answer")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });
        $("#modal-accept-answer button.positive.button").click(function () {
            var dimmer = $("#current-segment .dimmer");
            dimmer.addClass("active");

            var question = $(this).parent().parent().find("input[name='question']").val();
            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/control-panel/reviewer/accept-answer/ajax",
                data: {question: question},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("لم يتم قبول الاجابة، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("تم قبول الاجابة بنجاح" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    var segment = $("#current-segment");
                    segment.removeAttr("id");
                    segment.find("button[data-action='accept-answer']").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
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

        //Reject answer
        $("button[data-action='reject-answer']").click(function () {
            var button = $(this);
            button.parent().attr("id", "current-segment");
            button.addClass("loading");
            $("#modal-reject-answer input[name='question']").val(button.data("content"));
            $("#modal-reject-answer")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });
        $("#modal-reject-answer button.positive.button").click(function () {
            var dimmer = $("#current-segment .dimmer");
            dimmer.addClass("active");

            var question = $(this).parent().parent().find("input[name='question']").val();
            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/control-panel/reviewer/reject-answer/ajax",
                data: {question: question},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("لم يتم رفض الاجابة، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("تم رفض الاجابة بنجاح" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    var segment = $("#current-segment");
                    segment.removeAttr("id");
                    segment.find("button[data-action='reject-answer']").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
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

        //Delete question
        $("button[data-action='delete-question']").click(function () {
            var button = $(this);
            button.parent().attr("id", "current-segment");
            button.addClass("loading");
            $("#modal-delete-question input[name='question']").val(button.data("content"));
            $("#modal-delete-question")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });
        $("#modal-delete-question button.positive.button").click(function () {
            var dimmer = $("#current-segment .dimmer");
            dimmer.addClass("active");

            var question = $(this).parent().parent().find("input[name='question']").val();
            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/control-panel/reviewer/delete-question/ajax",
                data: {question: question},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("لم يتم حذف السؤال، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("تم حذف السؤال بنجاح" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    var segment = $("#current-segment");
                    segment.removeAttr("id");
                    segment.find("button[data-action='delete-question']").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
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

        $("button.negative.button").click(function () {
            var segment = $("#current-segment");
            segment.removeAttr("id");
            segment.find("button[data-action='accept-answer']").removeClass("loading");
            segment.find("button[data-action='reject-answer']").removeClass("loading");
            segment.find("button[data-action='delete-question']").removeClass("loading");
        });
    </script>
@endsection