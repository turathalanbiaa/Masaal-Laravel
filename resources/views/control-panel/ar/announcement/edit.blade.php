@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>{{$announcement->content}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu" id="special-menu">
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
                <a class="item" href="/control-panel/logout">
                    <i class="shutdown big icon" style="margin: 0;"></i>&nbsp;
                    <span>تسجيل خروج</span>
                </a>
            </div>
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error message" id="message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("ArUpdateAnnouncementMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("ArUpdateAnnouncementMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header">تحرير الاعلان</h3>

                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/announcements/{{$announcement->id}}">
                            @csrf()
                            @method("PUT")

                            <div class="field">
                                <label for="content">الاعلان</label>
                                <textarea rows="5" name="content" id="content">{{$announcement->content}}</textarea>
                            </div>

                            <div class="field" style="text-align: center;">
                                <button type="submit" class="ui green button">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection