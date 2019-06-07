@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>المنشورات</title>
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
                <a class="item" href="/control-panel/posts">
                    <i class="newspaper big icon" style="margin: 0;"></i>&nbsp;
                    <span>المنشورات</span>
                </a>
                <a class="item active" href="/control-panel/posts/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة منشور</span>
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

        @if(session("ArCreatePostMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArCreatePostMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header">اضافة منشور جديد</h3>

                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/posts" enctype="multipart/form-data">
                            @csrf()

                            <div class="field">
                                <label for="title">عنوان المنشور</label>
                                <input type="text" name="title" id="title" value="{{old("title")}}">
                            </div>

                            <div class="field">
                                <label for="content">بعض التفاصيل حول المنشور</label>
                                <textarea rows="5" name="content" id="content">{{old("content")}}</textarea>
                            </div>

                            <div class="field">
                                <label for="image">اختر الصورة ... حقل أخياري</label>
                                <input type="file" name="image" id="image" placeholder="أختر الصورة من هنا .. أختياري">
                            </div>

                            <div class="field" style="text-align: center;">
                                <button type="submit" class="ui green button">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
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
    </script>
@endsection