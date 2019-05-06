@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>الحسابات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu" id="special-menu">
                <a class="item" href="/control-panel/{{$lang}}">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item active" href="/control-panel/{{$lang}}/managers">
                    <i class="setting big icon" style="margin: 0;"></i>&nbsp;
                    <span>الحسابات</span>
                </a>
                <a class="item" href="/control-panel/{{$lang}}/admin/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة حساب</span>
                </a>
                <a class="item" href="/control-panel/{{$lang}}/logout">
                    <i class="shutdown big icon" style="margin: 0;"></i>&nbsp;
                    <span>تسجيل خروج</span>
                </a>
            </div>
        </div>

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui big form" method="get" action="/control-panel/{{$lang}}/managers" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" placeholder="بحث عن مسؤول" value="@if(isset($_GET["query"])) {{$_GET["query"]}} @endif" name="query" style="text-align: right;">
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
                                <th class="center aligned">التاريخ</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td class="center aligned">{{$admin->id}}</td>
                                    <td class="center aligned">{{$admin->name}}</td>
                                    <td class="center aligned">{{$admin->username}}</td>
                                    <td class="center aligned">{{$admin->date}}</td>
                                    <td class="center aligned">
                                        <a class="ui blue button" href="/control-panel/{{$lang}}/admin/info?id={{$admin->id}}" >تحرير</a>
                                        <a class="ui red button" data-action="delete" data-id="{{$admin->id}}" data-name="{{$admin->name}}">حذف</a>
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

        $("a[data-action='delete']").click(function () {
            var a = $(this);
            a.parent().parent().attr("id", "row-delete");
            a.addClass("loading");
            $("#number").html(a.data("id"));
            $("#name").html(a.data("name"));
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
            var success = false;

            $.ajax({
                type: "POST",
                url: "/control-panel/admin/delete",
                data: {_token:_token, id:id},
                datatype: 'json',
                success: function(result) {
                    if (result["notFound"] == true)
                        snackbar("هذا المسؤول غير موجود." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم حذف المسؤول, يرجى اعدة المحاولة." , 3000 , "error");

                    else if (result["success"] == true)
                    {
                        snackbar("تم حذف المسؤول." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    var tr = $("#row-delete");
                    tr.removeAttr("id");
                    tr.find("a").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
                            tr.addClass("scale");
                            tr.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });

        $("button.negative.button").click(function () {
            var tr = $("#row-delete");
            tr.removeAttr("id");
            tr.find("a").removeClass("loading");
        });

        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection