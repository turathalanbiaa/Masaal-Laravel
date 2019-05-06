@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>انشاء حساب جديد</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.$lang.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">
                    <i class="home big icon"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item" href="/control-panel/{{$lang}}/managers">
                    <i class="setting big icon"></i>&nbsp;
                    <span>ادارة الحسابات</span>
                </a>
                <a class="item active" href="/control-panel/{{$lang}}/admin/create">
                    <i class="add big icon"></i>&nbsp;
                    <span>اضافة حساب</span>
                </a>
                <a class="item" href="/control-panel/{{$lang}}/logout">
                    <i class="shutdown big icon"></i>&nbsp;
                    <span>تسجيل خروج</span>
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

        @if(session("ArInfoMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 class="ui center aligned header">{{session("ArInfoMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header">انشاء حساب جديد</h3>
                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/{{$lang}}/admin/create">
                            {!! csrf_field() !!}
                            <div class="field">
                                <label for="name">الاسم الحقيقي</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="name" value="{{old("name")}}" id="name">
                                </div>
                            </div>

                            <div class="field">
                                <label for="username">اسم المستخدم</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="username" value="{{old("username")}}" id="username">
                                </div>
                            </div>

                            <div class="field">
                                <label for="password">كلمة المرور</label>
                                <div class="sixteen wide field">
                                    <input type="password" value="" name="password" id="password">
                                </div>
                            </div>

                            <div class="field">
                                <label for="password-confirmation">أعد كتابة كلمة المرور</label>
                                <div class="sixteen wide field">
                                    <input type="password" value="" name="password_confirmation" id="password-confirmation">
                                </div>
                            </div>

                            <h4 class="ui green dividing header">الصلاحيات</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="manager">مدير</label>
                                        <input type="checkbox" name="manager" value="1" tabindex="0" class="hidden" id="manager">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="distributor">موزع</label>
                                        <input type="checkbox" name="distributor" value="1" tabindex="0" class="hidden" id="distributor">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="reviewer">مدقق</label>
                                        <input type="checkbox" name="reviewer" value="1" tabindex="0" class="hidden" id="reviewer">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="respondent">مجيب</label>
                                        <input type="checkbox" name="respondent" value="1" tabindex="0" class="hidden" id="respondent">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="announcement">اعلانات</label>
                                        <input type="checkbox" name="announcement" value="1" tabindex="0" class="hidden" id="announcement">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="post">منشورات</label>
                                        <input type="checkbox" name="post" value="1" tabindex="0" class="hidden" id="post">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="ui green button">حفظ</button>
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