@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>ارشيف الاسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui five item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item" href="/control-panel/respondent">
                    <i class="bars big icon" style="margin: 0;"></i>&nbsp;
                    <span>اسئلتي</span>
                </a>
                <a class="item" href="/control-panel/respondent/my-answers">
                    <i class="folder open big icon" style="margin: 0;"></i>&nbsp;
                    <span>اجوبتي</span>
                </a>
                <a class="item active" href="/control-panel/respondent/answers">
                    <i class="history big icon" style="margin: 0;"></i>&nbsp;
                    <span>ارشيف الاسئلة</span>
                </a>
                <a class="item" href="/control-panel/logout">
                    <i class="shutdown big icon" style="margin: 0;"></i>&nbsp;
                    <span>تسجيل خروج</span>
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
            <div class="ui placeholder segment">
                <div class="ui two column stackable center aligned grid">
                    <div class="ui vertical divider">
                        <i class="ui search icon"></i>
                    </div>
                    <div class="middle aligned row">
                        <div class="column">
                            <div class="ui icon header">
                                <i class="search green icon"></i>
                                <span>بحث عن طريق السؤال</span>
                            </div>
                            <div class="field">
                                <div class="ui search">
                                    <div class="ui fluid input">
                                        <form class="ui right aligned form" method="get" action="" style="width: 100%;">
                                            <input name="t" type="hidden" value="1">
                                            <input name="q" type="text" value="" placeholder="اكتب السؤال الذي تبحث عنه...">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="ui icon header">
                                <i class="search green icon"></i>
                                <span>بحث عن طريق الجواب</span>
                            </div>
                            <div class="field">
                                <div class="ui search">
                                    <div class="ui fluid input">
                                        <form class="ui right aligned form" method="get" action="" style="width: 100%;">
                                            <input name="t" type="hidden" value="2">
                                            <input name="q" type="text" value="" placeholder="اكتب الجواب الذي تبحث عنه...">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                        <p>
                            @if($question->status == \App\Enums\QuestionStatus::TEMP_ANSWER)
                                <span style="color: red;">السؤال قيد التدقيق.</span>
                            @else
                                <span style="color: red;">تم نشر السؤال.</span>
                            @endif
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

                        @if(($permission["manager"] == 1) || ($question->adminId == $currentAdminId))
                            <a class="ui inverted blue button" href="/control-panel/respondent/my-answers/{{$question->id}}/edit-answer">تعديل الاجابة</a>
                        @endif
                    </div>
                @empty
                    <div class="ui segment">
                        <div class="ui massive info message">
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui center aligned header">لاتوجد اسئلة</div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                        </div>
                    </div>
                @endforelse

                @if($questions->hasPages())
                    <div class="ui bottom teal center aligned inverted segment">
                        @if(isset($_GET["q"]) && isset($_GET["t"]))
                            {{$questions->appends(['t' => $_GET["t"], 'q' => $_GET["q"]])->links()}}
                        @else
                            {{$questions->links()}}
                        @endif
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
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection