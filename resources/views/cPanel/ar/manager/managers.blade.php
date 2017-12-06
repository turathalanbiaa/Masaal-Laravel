@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>ادارة الحسابات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        @if(session("InfoManagerMessage"))
            <div class="column">
                <div class="ui session info message">
                    <h2 style="text-align: center;">{{session("InfoManagerMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("DeleteManagerMessage"))
            <div class="column">
                <div class="ui session info message">
                    <h2 style="text-align: center;">{{session("DeleteManagerMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("UpdateManagerMessage"))
            <div class="column">
                <div class="ui session info message">
                    <h2 style="text-align: center;">{{session("UpdateManagerMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <div class="ui grid">
                    <div class="row">
                        <div class="sixteen wide mobile twelve wide tablet fourteen wide computer column">
                            <form class="ui form" method="get" action="/control-panel/{{$lang}}/managers/search" dir="rtl">
                                <div class="ui left icon input" style="width: 100%; text-align: right;">
                                    <input type="text" placeholder="بحث عن مسؤول" value="@if(isset($_GET["query"])) {{$_GET["query"]}} @endif" name="query" style="text-align: right;">
                                    <i class="search icon"></i>
                                </div>
                            </form>
                        </div>
                        <div class="sixteen wide mobile four wide tablet two wide computer column">
                            <a href="/control-panel/{{$lang}}/admin/create" class="ui fluid green button">أضافة مسؤول</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sixteen wide column">
                            @if($admins->count() > 0)
                                @include("cPanel.$lang.manager.result_search")
                            @else
                                <div class="ui divider"></div>
                                <div class="ui fluid info large message">
                                    <div class="ui hidden divider"></div>
                                    <div class="ui hidden divider"></div>
                                    <h3 class="ui center aligned header">لا توجد نتائج حول هذا البحث</h3>
                                    <div class="ui hidden divider"></div>
                                    <div class="ui hidden divider"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui modal">
        <h1 class="ui right aligned red header"> هل تريد حذف هذه المسؤول </h1>
        <div class="content" style="text-align: center;">
            <h3 class="ui center aligned teal header" id="admin-name"></h3>
            <div class="ui divider"></div>
            <form class="ui form" method="post" action="/control-panel/{{$lang}}/admin/delete">
                {!! csrf_field() !!}
                <input type="hidden" name="adminId" value="">
                <button type="submit" class="ui green button">نعم</button>
                <a class="ui red button" id="abort">لا</a>
            </form>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $("button[data-action='delete-admin']").click(function ()
        {
            var adminId = $(this).data('id');
            var adminName = $(this).data('content');
            $('h3#admin-name').text(adminName);
            $('input[name=adminId]:hidden').val(adminId);

            $('.ui.modal').modal('show');
        });

        $('#abort').click(function ()
        {
            $('.ui.modal').modal('hide');
        });

        $('.ui.session.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection