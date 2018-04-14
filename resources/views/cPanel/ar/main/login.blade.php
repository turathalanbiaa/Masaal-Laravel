@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>تسجيل الدخول</title>
@endsection

@section("content")
    <div class="ui tiny modal">
        <h3 class="ui right aligned top attached grey inverted header">
            <span>تسجيل الدخول الى لوحة التحكم</span>
        </h3>
        <div class="content">
            <div class="ui center aligned one column grid">
                <div class="column">
                    <div class="ui small image">
                        <img src="{{asset("/img/logo.png")}}">
                    </div>
                </div>
            </div>

            <div class="ui hidden divider"></div>
            <div class="ui divider"></div>
            <div class="ui hidden divider"></div>

            @if(count($errors))
                <div class="ui error fadeInUp animated message" style="padding: 14px 0;">
                    <ul style="text-align: right; direction: rtl;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session("ErrorRegisterMessage"))
                <div class="ui center aligned small bounce animated header">{{session("ErrorRegisterMessage")}}</div>
            @endif

            <form class="ui big form" dir="rtl" method="post" action="">
                {!! csrf_field() !!}
                <div class="field">
                    <input placeholder="اسم المستخدم" type="text" name="username" value="{{ old('username') }}">
                </div>
                <div class="field">
                    <input placeholder="كلمة المرور" type="password" name="password">
                </div>
                <button type="submit" class="ui black fluid big button">تسجيل الدخول</button>
            </form>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $('.ui.modal').modal({
            centered: false,
            blurring: true,
            closable: false
        })
            .modal('show');
    </script>
@endsection