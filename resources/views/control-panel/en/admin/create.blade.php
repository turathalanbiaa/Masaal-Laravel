@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>Create Account</title>
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
                <a class="item" href="/control-panel/admins">
                    <i class="users big icon" style="margin: 0;"></i>&nbsp;
                    <span>Accounts</span>
                </a>
                <a class="item active" href="/control-panel/admins/create">
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

        @if(session("EnCreateAdminMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("EnCreateAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui left aligned segment">
                <h3 class="ui center aligned green dividing header" style="padding: 10px 0; margin-bottom: 30px;">Create New Account</h3>
                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui big form" method="post" action="/control-panel/admins">
                            @csrf()

                            <div class="field">
                                <label for="name">Name</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="name" value="{{old("name")}}" id="name">
                                </div>
                            </div>

                            <div class="field">
                                <label for="username">Username</label>
                                <div class="sixteen wide field">
                                    <input type="text" name="username" value="{{old("username")}}" id="username">
                                </div>
                            </div>

                            <div class="field">
                                <label for="password">Password</label>
                                <div class="sixteen wide field">
                                    <input type="password" value="" name="password" id="password">
                                </div>
                            </div>

                            <div class="field">
                                <label for="password-confirmation">Rewrite Password</label>
                                <div class="sixteen wide field">
                                    <input type="password" value="" name="password_confirmation" id="password-confirmation">
                                </div>
                            </div>

                            <h4 class="ui green dividing header">Permission</h4>

                            <div class="inline fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="manager">Manager</label>
                                        <input type="checkbox" name="manager" value="1" tabindex="0" class="hidden" id="manager">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="distributor">Distributor</label>
                                        <input type="checkbox" name="distributor" value="1" tabindex="0" class="hidden" id="distributor">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="respondent">Respondent</label>
                                        <input type="checkbox" name="respondent" value="1" tabindex="0" class="hidden" id="respondent">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="reviewer">Reviewer</label>
                                        <input type="checkbox" name="reviewer" value="1" tabindex="0" class="hidden" id="reviewer">
                                    </div>
                                </div>


                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="announcement">Announcement</label>
                                        <input type="checkbox" name="announcement" value="1" tabindex="0" class="hidden" id="announcement">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="post">post</label>
                                        <input type="checkbox" name="post" value="1" tabindex="0" class="hidden" id="post">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <label for="translator">Translator</label>
                                        <input type="checkbox" name="translator" value="1" tabindex="0" class="hidden" id="translator">
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