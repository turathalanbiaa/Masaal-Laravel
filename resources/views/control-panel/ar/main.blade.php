@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>الاجوبة الميسرة</title>
@endsection

@section("content")
    <style>
        i.special.icon {
            padding: 25px 5px;
            margin: 0;
            font-size: 6rem;
            line-height: 1;
            vertical-align: middle;
            box-sizing: content-box;
        }

        .ui.card>.content {
            background-color: #00b5ad;
        }

        .ui.card>.content>a {
            color: white !important;
        }

        .ui.card>.content>a:hover,
        .ui.card>.content>a:focus {
            color: black !important;
        }
    </style>

    <div class="ui grid">
        <div class="sixteen wide column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="sixteen wide column">
            <div class="ui big segment">
                <div class="ui hidden divider"></div>

                <div class="ui center aligned relaxed grid">
                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="user special blue icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/admins">الحسابات</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="recycle special green icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/distribution-questions">الموزع</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="microphone alternate special yellow icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/my-questions">المجيب</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="eye special purple icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/reviewed-questions">المدقق</a>
                            </div>
                        </div>
                    </div>


                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="newspaper special pink icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/}/posts">المنشورات</a>
                            </div>
                        </div>
                    </div>


                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special red icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/}/announcements">الاعلانات</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special red icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/}/announcements">الترجمة</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special red icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/}/announcements">الاقسام</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special red icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/}/announcements">تسجيل الخروج</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui hidden divider"></div>
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