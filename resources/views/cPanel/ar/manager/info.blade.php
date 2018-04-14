@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>معلومات {{$admin->name}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.$lang.layout.welcome")
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error fadeInUp animated message" style="padding: 14px 0;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("UpdateMessage"))
            <div class="column">
                <div class="ui success fadeIn animated message">
                    <h2 style="text-align: center;">{{session("UpdateMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header"><span>جميع معلومات -</span> <span>{{$admin->name}}</span></h3>
                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/{{$lang}}/admin/update">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{$admin->id}}">
                            <div class="field">
                                <label for="name">الاسم الحقيقي</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="name" value="{{$admin->name}}" id="name">
                                </div>
                            </div>

                            <div class="field">
                                <label for="username">اسم المستخدم</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="username" value="{{$admin->username}}" id="username">
                                </div>
                            </div>

                            <h4 class="ui green dividing header">الصلاحيات</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="manager">مدير</label>
                                        <input type="checkbox" name="manager" value="1" tabindex="0" @if($admin->manager == 1) {{"checked"}} @endif class="hidden" id="manager">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="distributor">موزع</label>
                                        <input type="checkbox" name="distributor" value="1" tabindex="0" @if($admin->distributor == 1) {{"checked"}} @endif class="hidden" id="distributor">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="reviewer">مدقق</label>
                                        <input type="checkbox" name="reviewer" value="1" tabindex="0" @if($admin->reviewer == 1) {{"checked"}} @endif class="hidden" id="reviewer">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="respondent">مجيب</label>
                                        <input type="checkbox" name="respondent" value="1" tabindex="0" @if($admin->respondent == 1) {{"checked"}} @endif class="hidden" id="respondent">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="announcement">اعلانات</label>
                                        <input type="checkbox" name="announcement" value="1" tabindex="0" @if($admin->announcement == 1) {{"checked"}} @endif class="hidden" id="announcement">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="post">منشورات</label>
                                        <input type="checkbox" name="post" value="1" tabindex="0" @if($admin->post == 1) {{"checked"}} @endif class="hidden" id="post">
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
        $('.ui.checkbox').checkbox();
    </script>
@endsection