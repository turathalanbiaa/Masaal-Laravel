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
                                <a class="ui center aligned header" href="/control-panel/distributor">الموزع</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="microphone alternate special yellow icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/respondent">المجيب</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="eye special purple icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/reviewer">المدقق</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="newspaper special pink icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/posts">المنشورات</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special red icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/announcements">الاعلانات</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="clipboard list special orange flipped icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/categories">الاصناف</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="language special brown icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/translator">الترجمة</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="shutdown special black icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" data-action="logout">تسجيل الخروج</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui hidden divider"></div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui modal" id="modal-logout">
        <h2 class="ui center aligned top attached inverted header">
            <span style="color: white;">تسجيل الخروج</span>
        </h2>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <a class="ui massive inverted green button" href="/control-panel/logout?device=current">تسجيل الخروج من الجهاز الحالي</a>
                <a class="ui massive inverted green button" href="/control-panel/logout?device=all">تسجيل الخروج من جميع الاجهزة</a>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $("a[data-action='logout']").click(function () {
            //Show modal
            $("#modal-logout")
                .modal({
                    'transition': 'scale'
                })
                .modal("show");
        });
    </script>
@endsection