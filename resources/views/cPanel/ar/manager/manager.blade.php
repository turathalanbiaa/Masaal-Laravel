@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>ادارة المستخدمين</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            <div class="ui fluid right aligned segment">
                <div class="ui grid">
                    <div class="twelve wide column">
                        <form class="ui form" method="get" action="" dir="rtl">
                            <div class="ui left icon input" style="width: 100%; text-align: right;">
                                <input type="text" placeholder="بحث عن مسؤول" name="query" style="text-align: right;">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>
                    <div class="four wide column">
                        <a href="" class="ui fluid green button">أضافة مسؤول</a>
                    </div>

                    <div class="row">
                        <div class="sixteen wide column">
                            @include("cPanel.ar.manager.result_search")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection