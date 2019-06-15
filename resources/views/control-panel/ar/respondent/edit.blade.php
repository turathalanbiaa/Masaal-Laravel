@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>اجابة السؤال</title>
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
                <a class="item active" href="/control-panel/respondent">
                    <i class="bars big icon" style="margin: 0;"></i>&nbsp;
                    <span>اسئلتي</span>
                </a>
                <a class="item" href="/control-panel/respondent/my-answers">
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

        @if(session("ArAnswerQuestionMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("ArAnswerQuestionMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned teal segment">
                <h3><span style="color: #21ba45;">السؤال:- </span> {{$question->content}}</h3>
                <form class="ui form" method="post" action="/control-panel/respondent/{{$question->id}}" enctype="multipart/form-data">
                    @csrf()

                    <div class="field">
                        <label for="answer">الجواب</label>
                        <textarea name="answer" id="answer" placeholder="اكتب الاجابة هنا...">{{old("answer")}}</textarea>
                    </div>

                    <div class="field">
                        <label for="category_Id">اختر الصنف</label>
                        <div class="ui fluid search selection dropdown" id="categories">
                            <input type="hidden" name="categoryId" id="category_Id">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">بحث في الاصناف...</div>
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
                            <div class="default text">بحث في المواضيع...</div>
                            <div class="menu">
                                @foreach($tags as $tag)
                                    <div class="item" data-value="{{$tag->id}}">{{$tag->tag}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field" style="margin-top: 10px;">
                        <label for="image">صورة</label>
                        <input type="file" name="image" id="image" placeholder="ارفق صورة مع الأجابة... اختياري">
                    </div>

                    <div class="field">
                        <label for="video-link">رابط الفديو (YouTube Video ID)</label>
                        <input type="text" name="videoLink" value="{{old("videoLink")}}" id="video-link" placeholder="اكتب youtube video id هنا... اختياري">
                    </div>

                    <div class="field">
                        <label for="external-link">رابط المصدر</label>
                        <input type="text" name="externalLink" value="{{old("externalLink")}}" id="external-link" placeholder="اكتب رابط المصدر هنا... اختياري">
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
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
        $('.ui.selection.dropdown#categories').dropdown("set selected", "{{old("categoryId")}}");
        $('.ui.selection.dropdown#tags').dropdown("set selected", [
            @foreach(explode(",", old("tags")) as $tag)
                '{{$tag}}',
            @endforeach
        ]);
    </script>
@endsection