@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>مراجعة الأسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/reviewed-questions">مراجعة الاسئلة</a>
                <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
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
                                        <span>{{$question->Category->category}}</span>
                                    </p>

                                    <p>
                                        <span>الكلمات الدلالية</span>
                                        <i class="long arrow left icon" style="font-size: medium; font-weight: bold;"></i>
                                        @foreach($question->QuestionTags as $questionTag)
                                            <span>{{$questionTag->Tag->tag . "،"}}</span>
                                        @endforeach
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

                            <button class="ui inverted green button" data-action="accept" data-question-id="{{$question->id}}">قبول</button>
                            <a class="ui inverted blue button" href="/control-panel/{{$lang}}/info-question?id={{$question->id}}">تعديل</a>
                            <button class="ui inverted red button" data-action="reject" data-question-id="{{$question->id}}">رفض</button>
                            <button class="ui inverted pink button" data-action="delete" data-question-id="{{$question->id}}">حذف سؤال</button>
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
                            <div class="ui center aligned header">لاتوجد اسئلة جديدة لمراجعتها</div>
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

        $('.ui.accordion').accordion();

        $('.ui.embed').embed();

        $("button[data-action='accept']").click(function () {
            var button = $(this);
            var _token = "{!! csrf_token() !!}";
            var questionId = button.data('question-id');
            var dimmer = button.parent().find(".dimmer");
            var success = false;
            dimmer.addClass("active");

            $.ajax({
                type: "POST",
                url: '/control-panel/acceptAnswer',
                data: {_token:_token, questionId:questionId},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم قبو ل الاجابة !!، حاول مرة اخرى." , 3000 , "error");

                    else if (result["success"] == true)
                    {
                        snackbar("تم قبول الاجابة بنجاح" , 3000 , "success");
                        success = true;
                    }

                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    dimmer.removeClass("active");

                    if(success)
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

        $("button[data-action='reject']").click(function () {
            var button = $(this);
            var _token = "{!! csrf_token() !!}";
            var questionId = button.data('question-id');
            var dimmer = button.parent().find(".dimmer");
            var success = false;
            dimmer.addClass("active");

            $.ajax({
                type: "POST",
                url: '/control-panel/rejectAnswer',
                data: {_token:_token, questionId:questionId},
                datatype: 'json',
                success: function(result) {

                    console.log(result["message"])
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] == true)
                    {
                        snackbar("تم رفض الاجابة بنجاح" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                },
                complete : function() {
                    dimmer.removeClass("active");

                    if(success)
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

        $("button[data-action='delete']").click(function () {
            var button = $(this);
            var _token = "{!! csrf_token() !!}";
            var questionId = button.data('question-id');
            var dimmer = button.parent().find(".dimmer");
            var success = false;
            dimmer.addClass("active");

            $.ajax({
                type: "POST",
                url: '/control-panel/reviewer/delete-question',
                data: {_token:_token, questionId:questionId},
                datatype: 'json',
                success: function(result) {

                    console.log(result["message"])
                    if (result["question"] == "NotFound")
                        snackbar("لايوجد مثل هذا السؤال." , 3000 , "warning");

                    else if (result["success"] == true)
                    {
                        snackbar("تم حذف السؤال بنجاح." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                },
                complete : function() {
                    dimmer.removeClass("active");

                    if(success)
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

        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection