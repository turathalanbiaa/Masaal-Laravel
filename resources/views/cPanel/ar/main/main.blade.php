@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>الاجوبة الميسرة</title>
@endsection

@section("content")
    <style>
        i.special.icon {
            padding: 5px;
            margin: 0;
            font-size: 10em;
            line-height: 1;
            vertical-align: middle;
        }
    </style>

    <div class="ui grid">
        <div class="sixteen wide column">
            @include("cPanel.ar.layout.welcome")
        </div>

        @if(session("ArPermissionMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 class="ui center aligned header">{{session("ArPermissionMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="sixteen wide column">
            <div class="ui segment">
                <div class="ui center aligned relaxed grid">
                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="user special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/managers">ادارة الحسابات</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="recycle special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/distribution-questions">الموزع</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="microphone alternate special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/my-questions">المجيب</a>
                            </div>
                        </div>
                    </div>

                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="eye special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/reviewed-questions">المدقق</a>
                            </div>
                        </div>
                    </div>


                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="newspaper special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/posts">المنشورات</a>
                            </div>
                        </div>
                    </div>


                    <div class="five wide computer five wide tablet eight wide mobile column">
                        <div class="ui fluid card">
                            <div class="image">
                                <i class="bullhorn special teal icon"></i>
                            </div>
                            <div class="content">
                                <a class="ui center aligned header" href="/control-panel/{{$lang}}/announcements">الاعلانات</a>
                            </div>
                        </div>
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