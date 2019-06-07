@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>الاصناف</title>
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
                <a class="item active" href="/control-panel/categories">
                    <i class="clipboard list big flipped icon" style="margin: 0;"></i>&nbsp;
                    <span>الاصناف</span>
                </a>
                <a class="item" href="/control-panel/categories/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة صنف</span>
                </a>
            </div>
        </div>

        @if(session("ArUpdateCategoryMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("ArUpdateCategoryMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("ArDeleteCategoryMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("ArDeleteCategoryMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui form" method="get" action="/control-panel/categories" dir="rtl">
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
                                <th class="center aligned">الصنف</th>
                                <th class="center aligned">خيارات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="center aligned">{{$category->id}}</td>
                                    <td class="center aligned">{{$category->category}}</td>
                                    <td class="center aligned">
                                        <a class="ui blue button" href="/control-panel/categories/{{$category->id}}/edit">تحرير</a>
                                        <button class="ui red button" data-action="delete-category" data-content="{{$category->id}}">حذف</button>
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

                    @if($categories->hasPages())
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
    <div class="ui mini modal" id="modal-delete-category">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">هل انت متأكد من حذف الصنف؟</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-category').submit();">نعم</button>
                <button class="ui negative button">لا</button>
            </div>
        </div>
    </div>
    <form method="post" action="" id="form-delete-category">
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
        $("button[data-action='delete-category']").click(function () {
            //Show modal delete category
            $("#modal-delete-category")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            //Fill form delete category
            $("#form-delete-category").attr("action","/control-panel/categories/"+$(this).data("content"))
        });
    </script>
@endsection