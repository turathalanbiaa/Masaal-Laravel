@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>{{$admin->name}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.en.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>Home</span>
                </a>
                <a class="item active" href="/control-panel/admins">
                    <i class="users big icon" style="margin: 0;"></i>&nbsp;
                    <span>Accounts</span>
                </a>
                <a class="item" href="/control-panel/admins/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>Add Account</span>
                </a>
            </div>
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("EnUpdateAdminMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("EnUpdateAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui left aligned segment">
                <h3 class="ui center aligned green dividing header" style="padding: 10px 0; margin-bottom: 30px;">
                    <span>Account for </span>
                    <span>{{$admin->name}}</span>
                </h3>
                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui big form" method="post" action="/control-panel/admins/{{$admin->id}}">
                            @method("PUT")
                            @csrf()

                            <div class="field">
                                <label for="name">Name</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="name" value="{{$admin->name}}" id="name">
                                </div>
                            </div>

                            <div class="field">
                                <label for="username">Username</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="username" value="{{$admin->username}}" id="username">
                                </div>
                            </div>

                            <h4 class="ui green dividing header">Permission</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="manager">Manager</label>
                                        <input type="checkbox" name="manager" value="1" tabindex="0" @if($admin->permission->manager == 1) {{"checked"}} @endif class="hidden" id="manager">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="distributor">Distributor</label>
                                        <input type="checkbox" name="distributor" value="1" tabindex="0" @if($admin->permission->distributor == 1) {{"checked"}} @endif class="hidden" id="distributor">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="respondent">Respondent</label>
                                        <input type="checkbox" name="respondent" value="1" tabindex="0" @if($admin->permission->respondent == 1) {{"checked"}} @endif class="hidden" id="respondent">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="reviewer">Reviewer</label>
                                        <input type="checkbox" name="reviewer" value="1" tabindex="0" @if($admin->permission->reviewer == 1) {{"checked"}} @endif class="hidden" id="reviewer">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="announcement">Announcement</label>
                                        <input type="checkbox" name="announcement" value="1" tabindex="0" @if($admin->permission->announcement == 1) {{"checked"}} @endif class="hidden" id="announcement">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="post">Post</label>
                                        <input type="checkbox" name="post" value="1" tabindex="0" @if($admin->permission->post == 1) {{"checked"}} @endif class="hidden" id="post">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="translator">Translator</label>
                                        <input type="checkbox" name="translator" value="1" tabindex="0" @if($admin->permission->translator == 1) {{"checked"}} @endif class="hidden" id="translator">
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: center;">
                                <button type="submit" class="ui green button">Save</button>
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
        $('.ui.checkbox').checkbox();
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection