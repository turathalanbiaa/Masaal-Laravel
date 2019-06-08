@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>الاعلانات</title>
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
                <a class="item active" href="/control-panel/announcements">
                    <i class="bullhorn big icon" style="margin: 0;"></i>&nbsp;
                    <span>الأعلانات</span>
                </a>
                <a class="item" href="/control-panel/announcements/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة اعلان</span>
                </a>
            </div>
        </div>

        @if(session("ArUpdateAnnouncementMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("ArUpdateAnnouncementMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArActiveAnnouncementMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArActiveAnnouncementMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArDeleteAnnouncementMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArDeleteAnnouncementMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui form" method="get" action="/control-panel/announcements" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" name="q" value="@if(isset($_GET["q"])) {{$_GET["q"]}} @endif" placeholder="بحث عن اعلان" style="text-align: right;">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>

                    <div class="sixteen wide column">
                        <table class="ui celled stackable large table">
                            <thead>
                            <tr>
                                <th class="center aligned">الرقم</th>
                                <th class="center aligned">الاعلان</th>
                                <th class="center aligned">تاريخ الرفع</th>
                                <th class="center aligned">حالة الاعلان</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($announcements as $announcement)
                                <tr>
                                    <td class="center aligned">{{$announcement->id}}</td>
                                    <td class="center aligned">{{$announcement->content}}</td>
                                    <td class="center aligned">{{$announcement->time}}</td>
                                    <td class="center aligned">{{\App\Enums\AnnouncementActiveState::getAnnouncementActiveState($announcement->active)}}</td>
                                    <td class="center aligned">
                                        @if($announcement->active == \App\Enums\AnnouncementActiveState::ACTIVE)
                                            <button class="ui black button" onclick="$('#form-active-{{$announcement->id}}').submit();">الغاء التفعيل</button>
                                            <form method="post" action="/control-panel/announcements/{{$announcement->id}}" id="form-active-{{$announcement->id}}" style="display: none;">
                                                @csrf()
                                                @method("PUT")
                                                <input type="hidden" name="active" value="0">
                                            </form>
                                        @else
                                            <button class="ui green button" onclick="$('#form-active-{{$announcement->id}}').submit();">تفعيل الاعلان</button>
                                            <form method="post" action="/control-panel/announcements/{{$announcement->id}}" id="form-active-{{$announcement->id}}" style="display: none;">
                                                @csrf()
                                                @method("PUT")
                                                <input type="hidden" name="active" value="1">
                                            </form>
                                        @endif
                                        <a class="ui blue button" href="/control-panel/announcements/{{$announcement->id}}/edit">تحرير</a>
                                        <button class="ui red button" data-action="delete-announcement" data-content="{{$announcement->id}}">حذف</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="ui center aligned header">
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                            <span>لا توجد نتائج</span>
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($announcements->hasPages())
                        <div class="sixteen wide teal center aligned column">
                            @if(isset($_GET["q"]))
                                {{$announcements->appends(['q' => $_GET["q"]])->links()}}
                            @else
                                {{$announcements->links()}}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal" id="modal-delete-announcement">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف الاعلان؟</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-announcement').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form method="post" action="" id="form-delete-announcement">
        @csrf()
        @method("DELETE")
    </form>
@endsection

@section("script")
    <script>
        $(document).ready(function () {
            var pagination = $(".pagination");
            pagination.removeClass("pagination").addClass("ui right aligned pagination teal menu");
            pagination.css("padding","0");
            pagination.find('li').addClass('item');
        });
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
        $("button[data-action='delete-announcement']").click(function () {
            //Show modal delete announcement
            $("#modal-delete-announcement")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            //Fill form delete announcement
            $("#form-delete-announcement").attr("action","/control-panel/announcements/"+$(this).data("content"))
        });
    </script>
@endsection