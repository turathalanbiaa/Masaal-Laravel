@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>المنشورات</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu">
                <a class="item" href="/control-panel/{{$lang}}/main">الرئيسية</a>
                <a class="item active" href="/control-panel/{{$lang}}/posts">المنشورات</a>
                <a class="item" href="/control-panel/{{$lang}}/post/create">اضافة منشور</a>
                <a class="item" href="/control-panel/{{$lang}}/logout">تسجيل خروج</a>
            </div>
        </div>

        @if(session("ArInfoMessage"))
            <div class="column">
                <div class="ui info message">
                    <h2 class="ui center aligned header">{{session("ArInfoMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui form" method="get" action="/control-panel/{{$lang}}/posts" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" placeholder="بحث عن منشور" value="@if(isset($_GET["query"])) {{$_GET["query"]}} @endif" name="query" style="text-align: right;">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>

                    <div class="sixteen wide column">
                        <table class="ui celled unstackable table">
                            <thead>
                            <tr>
                                <th class="center aligned">الرقم</th>
                                <th class="center aligned">عنوان المنشور</th>
                                <th class="center aligned">التاريخ</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($posts) > 0)
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="center aligned">{{$post->id}}</td>
                                        <td class="center aligned">{{$post->title}}</td>
                                        <td class="center aligned">{{$post->time}}</td>
                                        <td class="center aligned">
                                            <div class="ui fluid buttons">
                                                <button class="ui red button" data-action="delete" data-id="{{$post->id}}">حذف</button>
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

                    @if($posts->hasPages())
                        <div class="sixteen wide teal center aligned column">
                            @if(isset($_GET["query"]))
                                {{$posts->appends(['query' => $_GET["query"]])->links()}}
                            @else
                                {{$posts->links()}}
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
            <span>هل انت متأكد من حذف المنشور !!!</span>
        </h3>
        <div class="content">
            <div class="ui hidden divider"></div>

            <h3 class="ui center aligned header">
                <span>رقم المنشور - </span>
                <span id="number"></span>
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
            var button = $(this);
            button.parent().parent().parent().attr("id", "row-delete");
            button.addClass("loading");
            $("#number").html(button.data("id"));
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
                url: "/control-panel/post/delete",
                data: {_token:_token, id:id},
                datatype: 'json',
                success: function(result) {
                    if (result["notFound"] == true)
                        snackbar("هذا المنشور غير موجود." , 3000 , "warning");

                    else if (result["success"] == false)
                        snackbar("لم يتم حذف المنشور, يرجى اعدة المحاولة." , 3000 , "error");

                    else if (result["success"] == true)
                    {
                        snackbar("تم حذف المنشور." , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("تحقق من الاتصال بالانترنت" , 3000 , "error");
                } ,
                complete : function() {
                    var tr = $("#row-delete");
                    tr.removeAttr("id");
                    tr.find("button").removeClass("loading");
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
            tr.find("button").removeClass("loading");
        });

        $('.ui.info.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection