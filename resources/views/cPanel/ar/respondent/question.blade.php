@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>عرض السؤال</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        @if(count($errors))
            <div class="ui error message" id="message">
                <ul class="list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned teal segment">
                <div class="ui dimmer" id="dimmer">
                    <div class="ui text loader">جاري التحميل...</div>
                </div>
                <h3><span style="color: #21ba45;">السؤال:- </span> {{$question->content}}</h3>
                <form class="ui form" method="post" action="/control-panel/{{$lang}}/question-answer" enctype="multipart/form-data">
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
                        <div class="ui fluid multiple search selection dropdown">
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

                    <div class="field">
                        <label>ارفاق صورة</label>
                    </div>

                    <div class="field">
                        <div class="ui action input">
                            <label for="attachmentName" class="ui icon button btn-file">
                                <i class="attachment file icon"></i>
                                <input type="file" id="attachmentName" name="attachmentName" style="display: none">
                            </label>
                            <input type="text" name="j" id="_attachmentName">
                        </div>
                    </div>

                    <div class="field">
                        <label for="external-link">ارفاق رابط المصدر</label>
                        <input type="text" name="externalLink" id="external-link" placeholder="اكتب رابط المصدر هنا ...اختياري">
                    </div>

                    <div class="field">
                        <label for="video-link">ارفاق رابط الفديو</label>
                        <input type="text" name="videoLink" id="video-link" placeholder="اكتب رابط الفديو هنا ...اختياري">
                    </div>

                    <button type="submit" class="ui green button">حفظ</button>
                </form>
                <button class="ui left floated red button" data-token="{!! csrf_token() !!}" data-question-id="{{$question->id}}" data-action="change-question-type">
                    @if($question->type == \App\Enums\QuestionType::FEQHI)
                        {{"تحويل الى العقائد"}}
                    @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                        {{"تحويل الى الفقه"}}
                    @endif
                </button>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $('.ui.selection.dropdown').dropdown();
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

    <script>


        $('.btn-file :file').on('fileselect', function(event, numFiles, label, size) {
            $('#attachmentName').attr('name', 'attachmentName');
            $('#_attachmentName').val(input.val());
        });
    </script>
@endsection