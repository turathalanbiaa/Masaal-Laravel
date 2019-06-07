@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>المنشورات</title>
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
                <a class="item active" href="/control-panel/posts">
                    <i class="newspaper big icon" style="margin: 0;"></i>&nbsp;
                    <span>المنشورات</span>
                </a>
                <a class="item" href="/control-panel/posts/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة منشور</span>
                </a>
            </div>
        </div>

        @if(session("ArUpdatePostMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("ArUpdatePostMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArDeletePostMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArDeletePostMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui form" method="get" action="/control-panel/posts" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" name="q" value="@if(isset($_GET["q"])) {{$_GET["q"]}} @endif" placeholder="بحث عن منشور" style="text-align: right;">
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
                                <th class="center aligned">تاريخ النشر</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td class="center aligned">{{$post->id}}</td>
                                    <td class="center aligned">{{$post->title}}</td>
                                    <td class="center aligned">{{$post->time}}</td>
                                    <td class="center aligned">
                                        <a class="ui green button" href="/control-panel/posts/{{$post->id}}">عرض</a>
                                        <a class="ui blue button" href="/control-panel/posts/{{$post->id}}/edit">تحرير</a>
                                        <button class="ui red button" data-action="delete-post" data-content="{{$post->id}}">حذف</button>
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

                    @if($posts->hasPages())
                        <div class="sixteen wide teal center aligned column">
                            @if(isset($_GET["q"]))
                                {{$posts->appends(['q' => $_GET["q"]])->links()}}
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
    <div class="ui mini modal" id="modal-delete-post">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف المنشور؟</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-post').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form method="post" action="" id="form-delete-post">
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
        $("button[data-action='delete-post']").click(function () {
            //Show modal delete post
            $("#modal-delete-post")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            //Fill form delete post
            $("#form-delete-post").attr("action","/control-panel/posts/"+$(this).data("content"))
        });
    </script>
@endsection