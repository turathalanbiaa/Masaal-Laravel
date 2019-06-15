@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>تحرير الاجابة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item" href="/control-panel/respondent">
                    <i class="bars big icon" style="margin: 0;"></i>&nbsp;
                    <span>اسئلتي</span>
                </a>
                <a class="item active" href="/control-panel/respondent/my-answers">
                    <i class="folder open big icon" style="margin: 0;"></i>&nbsp;
                    <span>اجوبتي</span>
                </a>
                <a class="item" href="/control-panel/respondent/answers">
                    <i class="history big icon" style="margin: 0;"></i>&nbsp;
                    <span>ارشيف الاسئلة</span>
                </a>
            </div>
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error message" id="message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("ArUpdateAnswerMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("ArUpdateAnswerMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned teal segment">
                <h3><span style="color: #21ba45;">السؤال:- </span> {{$question->content}}</h3>
                <form class="ui form" method="post" action="/control-panel/respondent/my-answers/{{$question->id}}/update-answer" enctype="multipart/form-data">
                    @csrf()

                    <div class="field">
                        <label for="answer">الجواب</label>
                        <textarea name="answer" id="answer" placeholder="اكتب الاجابة هنا...">{{$question->answer}}</textarea>
                    </div>

                    <div class="field">
                        <label for="category_Id">اختر الصنف</label>
                        <div class="ui fluid search selection dropdown" id="categories">
                            <input type="hidden" name="categoryId" id="category_Id">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث في الاصناف... </div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item" data-value="{{$category->id}}">{{$category->category}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tags">اختر الموضوع (المواضيع)</label>
                        <div class="ui fluid multiple search selection dropdown" id="tags">
                            <input type="hidden" name="tags" id="tags">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث في المواضيع... </div>
                            <div class="menu">
                                @foreach($tags as $tag)
                                    <div class="item" data-value="{{$tag->id}}">{{$tag->tag}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="ten wide field" style="padding: 0;">
                            <label for="image" style="padding-left: 10px;">صورة</label>
                            <input type="file" name="image" id="image" placeholder="ارفق صورة مع الأجابة... اختياري">
                        </div>

                        <div class="six wide field" id="filed-card">
                            @if(!is_null($question->image))
                                <div class="ui fluid card">
                                    <div class="blurring dimmable image">
                                        <div class="ui dimmer">
                                            <div class="content">
                                                <div class="center">
                                                    <button class="ui inverted red button" data-action="delete-image">حذف الصورة</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ui fluid bordered image">
                                            <img src="{{asset("storage/" . $question->image)}}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="field">
                        <label for="video-link">رابط الفديو (YouTube Video ID)</label>
                        <input type="text" name="videoLink" value="{{$question->videoLink}}" id="video-link" placeholder="اكتب youtube video id هنا... اختياري">
                    </div>

                    <div class="field">
                        <label for="external-link">رابط المصدر</label>
                        <input type="text" name="externalLink" value="{{$question->externalLink}}" id="external-link" placeholder="اكتب رابط المصدر هنا... اختياري">
                    </div>

                    <div class="field" style="text-align: center;">
                        <button type="submit" class="ui green button">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
        $('.ui.selection.dropdown#categories').dropdown("set selected", "{{$question->categoryId}}");
        $('.ui.selection.dropdown#tags').dropdown("set selected" ,[
            @foreach($question->QuestionTags as $questionTag)
                '{{$questionTag->tagId}}',
            @endforeach
        ]);

        //Remove image
        $('.ui.fluid.card .image').dimmer({
            on: 'hover'
        });
        $("button[data-action='delete-image']").click(function () {
            var h3 = "<h3 class='ui center aligned green header' width='100%'>تم حذف الصورة</h3>";
            var input = "<input type='hidden' name='delete' value='1'>";
            var filedCard = $("#filed-card").html(h3 + input);
        });
    </script>
@endsection