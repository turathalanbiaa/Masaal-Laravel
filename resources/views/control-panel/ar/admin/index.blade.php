@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>الحسابات</title>
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
                <a class="item active" href="/control-panel/admins">
                    <i class="users big icon" style="margin: 0;"></i>&nbsp;
                    <span>الحسابات</span>
                </a>
                <a class="item" href="/control-panel/admins/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة حساب</span>
                </a>
            </div>
        </div>

        @if(session("ArUpdateAdminMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("ArUpdateAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArDeleteAdminMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArDeleteAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui big form" method="get" action="/control-panel/admins" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" placeholder="بحث عن حساب..." value="@if(isset($_GET["q"])){{$_GET["q"]}}@endif" name="q" style="text-align: right;">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>

                    <div class="sixteen wide column">
                        <table class="ui celled stackable large table">
                            <thead>
                            <tr>
                                <th class="center aligned">الرقم</th>
                                <th class="center aligned">الاسم الحقيقي</th>
                                <th class="center aligned">اسم المستخدم</th>
                                <th class="center aligned">آخر تسجيل دخول</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td class="center aligned">{{$admin->id}}</td>
                                    <td class="center aligned">{{$admin->name}}</td>
                                    <td class="center aligned">{{$admin->username}}</td>
                                    <td class="center aligned">{{is_null($admin->last_login_date)? "لم يقم بتسجيل الدخول":$admin->last_login_date}}</td>
                                    <td class="center aligned">
                                        <a class="ui blue button" href="/control-panel/admins/{{$admin->id}}/edit" >تحرير</a>
                                        <button class="ui red button" data-action="delete-admin" data-content="{{$admin->id}}">حذف</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
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

                    @if($admins->hasPages())
                        <div class="sixteen wide center aligned column">
                            @if(isset($_GET["q"]))
                                {{$admins->appends(['q' => $_GET["q"]])->links("pagination::semantic-ui")}}
                            @else
                                {{$admins->links("pagination::semantic-ui")}}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal" id="modal-delete-admin">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف الحساب؟</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-admin').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form method="post" action="" id="form-delete-admin">
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
        $("button[data-action='delete-admin']").click(function () {
            //Show modal delete admin
            $("#modal-delete-admin")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            //Fill form delete admin
            $("#form-delete-admin").attr("action","/control-panel/admins/"+$(this).data("content"))
        });
    </script>
@endsection