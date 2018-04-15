@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>ادارة الحسابات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/managers">ادارة الحسابات</a>
                <a class="item" href="/control-panel/{{$lang}}/admin/create">اضافة حساب</a>
                <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
            </div>
        </div>

        @if(session("permissionMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 style="text-align: center;">{{session("permissionMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("InfoMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 style="text-align: center;">{{session("InfoMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("UpdateMessage"))
            <div class="column">
                <div class="ui session info message">
                    <h2 style="text-align: center;">{{session("UpdateMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui form" method="get" action="/control-panel/{{$lang}}/managers" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" placeholder="بحث عن مسؤول" value="@if(isset($_GET["query"])) {{$_GET["query"]}} @endif" name="query" style="text-align: right;">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>

                    <div class="sixteen wide column">
                        <table class="ui celled unstackable table">
                            <thead>
                            <tr>
                                <th class="center aligned">الرقم</th>
                                <th class="center aligned">الاسم الحقيقي</th>
                                <th class="center aligned">اسم المستخدم</th>
                                <th class="center aligned">التاريخ</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($admins) > 0)
                                @foreach($admins as $admin)
                                    <tr>
                                        <td class="center aligned">{{$admin->id}}</td>
                                        <td class="center aligned">{{$admin->name}}</td>
                                        <td class="center aligned">{{$admin->username}}</td>
                                        <td class="center aligned">{{$admin->date}}</td>
                                        <td class="center aligned">
                                            <div class="ui fluid buttons">
                                                <a href="/control-panel/{{$lang}}/admin/info?id={{$admin->id}}" class="ui teal button">تحرير</a>
                                                <button class="ui red button" data-action="delete" data-id="{{$admin->id}}" data-name="{{$admin->name}}">حذف</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
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
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if($admins->hasPages())
                        <div class="sixteen wide teal center aligned column">
                            @if(isset($_GET["query"]))
                                {{$admins->appends(['query' => $_GET["query"]])->links()}}
                            @else
                                {{$admins->links()}}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal">
        <h3 class="ui center aligned top attached grey inverted header">
            <span>هل انت متأكد من حذف المسؤول !!!</span>
        </h3>
        <div class="content">
            <div class="ui hidden divider"></div>

            <h3 class="ui center aligned header">
                <span>صاحب الرقم - </span>
                <span id="number"></span>
                <br>
                <span>والاسم :- </span>
                <span id="name"></span>
            </h3>

            <div class="ui divider"></div>

            <div class="actions" style="text-align: center;">
                <button class="ui positive button">نعم</button>
                <button class="ui negative button">لا</button>
            </div>

            <div class="ui hidden divider"></div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $(document).ready(function () {
            var pagination = $(".pagination");
            pagination.removeClass("pagination").addClass("ui right aligned pagination teal menu");
            pagination.css("padding","0");
            pagination.find('li').addClass('item');
        });

        $("button[data-action='delete']").click(function () {
            $("#number").html($(this).data("id"));
            $("#name").html($(this).data("name"));
            $(".modal")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });

        $("button.positive.button").click(function () {
            var id = $("#number").html();
            var _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "/control-panel/{{$lang}}/admin/delete",
                data: {_token:_token, id:id},
                datatype: 'json',
                success: function(result) {
                    if (result["notFound"] == true)
                    {
                        snackbar("هذا المسؤول غير موجود." , 3000 , "warning");
                    }

                    if (result["success"] == false)
                    {
                        snackbar("لم يتم حذف المسؤول, يرجى اعدة المحاولة." , 3000 , "error");
                    }

                    if (result["success"] == true)
                    {
                        snackbar("تم حذف المسؤول." , 3000 , "success");
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {

                }
            });
        });

        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection