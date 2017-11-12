@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>تسجيل الدخول</title>
@endsection

@section("content")
    <div class="ui center aligned stackable grid">
        <div class="eight wide computer ten wide table sixteen wide mobile column">
            <div class="ui fluid right aligned teal segment">

                @if(count($errors))
                    <div class="ui error message" id="message">
                        <ul class="list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session("LoginMessage"))
                    {{session("LoginMessage")}}
                @endif

                <form class="ui right aligned form" method="post" action="/control-panel/{{$lang}}/login/validation">
                    {!! csrf_field() !!}

                    <div class="field">
                        <label>اسم المستخدم</label>
                        <input type="text" name="username" value="{{old("username")}}" placeholder="اكتب الاسم هنا">
                    </div>

                    <div class="field">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" placeholder="">
                    </div>

                    <div class="field">
                        <button type="submit" class="ui green button">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection