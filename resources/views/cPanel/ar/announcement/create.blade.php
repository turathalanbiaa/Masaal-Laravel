@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>الاعلانات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/announcements">الأعلانات</a>
                <a class="item" href="/control-panel/{{$lang}}/announcement/create">اضافة اعلان</a>
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
                <h3 class="ui center aligned green dividing header">اضافة اعلان جديد</h3>

                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/{{$lang}}/announcement/create">
                            {!! csrf_field() !!}

                            <div class="field">
                                <label for="content">الاعلان</label>
                                <textarea rows="5" name="content" id="content">{{old("content")}}</textarea>
                            </div>

                            <h4 class="ui green dividing header">حالة الاعلان</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <label>مفعل</label>
                                        <input type="radio" name="active" value="1" tabindex="0" class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <label>غير مفعل</label>
                                        <input type="radio" name="active" value="0" checked tabindex="0" class="hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="field" style="text-align: center;">
                                <button type="submit" class="ui green button">اضافة اعلان</button>
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
        $('.ui.checkbox').checkbox();

        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection