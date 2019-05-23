@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>تحرير السؤال</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/reviewed-questions">مراجعة الاسئلة</a>
                <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
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

        <div class="column">
            <div class="ui right aligned teal segment">
                <h3><span style="color: #21ba45;">السؤال:- </span> {{$question->content}}</h3>
                <form class="ui form" method="post" action="/control-panel/{{$lang}}/update-answer" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <input type="hidden" name="id" value="{{$question->id}}">

                    <div class="field">
                        <label for="answer">الجواب</label>
                        <textarea name="answer" id="answer" placeholder="اكتب الاجابة هنا ...">{{$question->answer}}</textarea>
                    </div>

                    <div class="field">
                        <label for="category_Id">صنف السؤال</label>
                        <div class="ui fluid search selection dropdown" id="categories">
                            <input type="hidden" name="categoryId" id="category_Id">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث عن صنف السؤال ... </div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item" data-value="{{$category->id}}">{{$category->category}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tags">اختر الموضوع</label>
                        <div class="ui fluid multiple search selection dropdown" id="tags">
                            <input type="hidden" name="tags" id="tags">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث عن الموضوع ... </div>
                            <div class="menu">
                                @foreach($tags as $tag)
                                    <div class="item" data-value="{{$tag->id}}">{{$tag->tag}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="ten wide field" style="padding: 0;">
                            <label for="image">ارفاق صورة</label>
                            <input type="file" name="image" id="image" placeholder="ارفق صورة مع الأجابة اذا كنت ترغب بذلك ... اختياري">
                        </div>
                        
                        <div class="six wide field" id="filed-card">
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
                        </div>
                    </div>


                    <div class="field">
                        <label for="external-link">ارفاق رابط المصدر</label>
                        <input type="text" name="externalLink" id="external-link" placeholder="اكتب رابط المصدر هنا ... اختياري" value="{{$question->videoLink}}">
                    </div>

                    <div class="field">
                        <label for="video-link">ارفاق رابط الفديو</label>
                        <input type="text" name="videoLink" id="video-link" placeholder="اكتب رابط الفديو هنا ... اختياري" value="{{$question->externalLink}}">
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
        $('.ui.selection.dropdown#categories').dropdown("set selected", "{{$question->categoryId}}");
        $('.ui.selection.dropdown#tags').dropdown("set selected" ,[
            @foreach($question->QuestionTags as $questionTag)
            '{{$questionTag->tagId}}',
            @endforeach
        ]);
        $('.ui.fluid.card .image').dimmer({
            on: 'hover'
        });
        $("button[data-action='delete-image']").click(function () {
            var h3 = "<h3 class='ui center aligned green header'>تم حذف الصورة بنجاح</h3>";
            var input = "<input type='hidden' name='delete' value='yes'>";
            var filedCard = $("#filed-card").html(h3 + input);
        });
    </script>
@endsection