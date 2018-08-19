@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>عرض السؤال</title>
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
                <form class="ui form" method="post" action="/control-panel/{{$lang}}/question-answer"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="questionId" value="{{$question->id}}">

                    <div class="field">
                        <label for="answer">الجواب</label>
                        <textarea name="answer" id="answer" placeholder="اكتب الاجابة هنا ..."></textarea>
                    </div>

                    <div class="field">
                        <label for="category_Id">صنف السؤال</label>
                        <div class="ui fluid search selection dropdown">
                            <input type="hidden" name="categoryId" id="category_Id">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث عن صنف السؤال ...</div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item" data-value="{{$category->id}}">{{$category->category}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tags">اختر الموضوع</label>
                        <div class="ui fluid multiple search selection dropdown">
                            <input type="hidden" name="tags" id="tags">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث عن الموضوع ...</div>
                            <div class="menu">
                                @foreach($tags as $tag)
                                    <div class="item" data-value="{{$tag->id}}">{{$tag->tag}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field" style="margin-top: 10px;">
                        <label for="image">ارفاق صورة</label>
                        <input type="file" name="image" id="image"
                               placeholder="ارفق صورة مع الأجابة اذا كنت ترغب بذلك ... اختياري">
                    </div>

                    <div class="field">
                        <label for="external-link">ارفاق رابط المصدر</label>
                        <input type="text" name="externalLink" id="external-link"
                               placeholder="اكتب رابط المصدر هنا ... اختياري">
                    </div>

                    <div class="field">
                        <label for="video-link">ارفاق رابط الفديو</label>
                        <input type="text" name="videoLink" id="video-link"
                               placeholder="اكتب رابط الفديو هنا ... اختياري">
                    </div>

                    <div class="field" style="text-align: center;">
                        <button type="submit" class="ui green button">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $('.ui.selection.dropdown').dropdown();
    </script>
@endsection