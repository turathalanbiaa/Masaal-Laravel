@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>المنشورات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/post/create">اضافة منشور</a>
                <a class="item" href="/control-panel/{{$lang}}/posts">المنشورات</a>
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

        @if(session("ArInfoMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 class="ui center aligned header">{{session("ArInfoMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header">اضافة منشور جديد</h3>

                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/{{$lang}}/post/create" enctype="multipart/form-data">
                            {!! csrf_field() !!}

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
                                <button type="submit" class="ui green button">اضافة منشور</button>
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
        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection