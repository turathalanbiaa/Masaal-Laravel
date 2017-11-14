@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title></title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.$lang.layout.welcome")
        </div>
        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header"><span>جميع معلومات -</span> <span>{{$admin->name}}</span></h3>
                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/{{$lang}}/admin/update">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{$admin->id}}">
                            <div class="field">
                                <label>الاسم الحقيقي</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="name" value="{{$admin->name}}">
                                </div>
                            </div>

                            <div class="field">
                                <label>اسم المستخدم</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="username" value="{{$admin->username}}">
                                </div>
                            </div>

                            <h4 class="ui green dividing header">الصلاحيات</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>مدير</label>
                                        <input type="checkbox" name="manager" tabindex="0" @if($admin->manager == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>موزع</label>
                                        <input type="checkbox" name="distributor" tabindex="0" @if($admin->distributor == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>مدقق</label>
                                        <input type="checkbox" name="reviewer" tabindex="0" @if($admin->reviewer == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>مجيب</label>
                                        <input type="checkbox" name="respondent" tabindex="0" @if($admin->respondent == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>اعلانات</label>
                                        <input type="checkbox" name="announcement" tabindex="0" @if($admin->announcement == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label>منشورات</label>
                                        <input type="checkbox" name="post" tabindex="0" @if($admin->post == 1) {{"checked"}} @endif class="hidden">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="ui green button">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $('.ui.checkbox')
            .checkbox()
        ;
    </script>
@endsection