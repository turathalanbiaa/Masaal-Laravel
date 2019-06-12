@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>Accounts</title>
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

        @if(session("EnUpdateAdminMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("EnUpdateAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        @if(session("EnDeleteAdminMessage"))
            <div class="column">
                <div class="ui {{(session('TypeMessage')=="Error")?"error":"success"}} message">
                    <h2 class="ui center aligned header">{{session("EnDeleteAdminMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui segment">
                <div class="ui grid">
                    <div class="sixteen wide column">
                        <form class="ui big form" method="get" action="/control-panel/admins" dir="ltr">
                            <div class="ui icon input" style="width: 100%;">
                                <input type="text" placeholder="search for account..." value="@if(isset($_GET["q"])){{$_GET["q"]}}@endif" name="q">
                                <i class="search icon"></i>
                            </div>
                        </form>
                    </div>

                    <div class="sixteen wide column">
                        <table class="ui celled stackable large table">
                            <thead>
                            <tr>
                                <th class="center aligned">No.</th>
                                <th class="center aligned">Name</th>
                                <th class="center aligned">Username</th>
                                <th class="center aligned">Last login Date</th>
                                <th class="center aligned">Options</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td class="center aligned">{{$admin->id}}</td>
                                    <td class="center aligned">{{$admin->name}}</td>
                                    <td class="center aligned">{{$admin->username}}</td>
                                    <td class="center aligned">{{is_null($admin->last_login_date)? "Not logged in":$admin->last_login_date}}</td>
                                    <td class="center aligned">
                                        <a class="ui blue button" href="/control-panel/admins/{{$admin->id}}/edit" >Edit</a>
                                        <button class="ui red button" data-action="delete-admin" data-content="{{$admin->id}}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="ui center aligned header">
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                            <div class="ui hidden divider"></div>
                                            <span>There are no results</span>
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
                        <div class="sixteen wide center aligned column">
                            @if(isset($_GET["q"]))
                                {{$admins->appends(['q' => $_GET["q"]])->links("pagination::semantic-ui")}}
                            @else
                                {{$admins->links("pagination::semantic-ui")}}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal" id="modal-delete-admin">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">Are you sure you want to delete the account?</span>
        </h3>
        <div class="content">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button" onclick="$('#form-delete-admin').submit();">Yes</button>
                <button class="ui negative button">No</button>
            </div>
        </div>
    </div>
    <form method="post" action="" id="form-delete-admin">
        @csrf()
        @method("DELETE")
    </form>
@endsection

@section("script")
    <script>
        $(document).ready(function () {
            var pagination = $(".pagination");
            pagination.removeClass("pagination").addClass("ui mini pagination menu");
            pagination.css("padding","0");
            pagination.find('li').addClass('item');
        });
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
        $("button[data-action='delete-admin']").click(function () {
            //Show modal delete admin
            $("#modal-delete-admin")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
            //Fill form delete admin
            $("#form-delete-admin").attr("action","/control-panel/admins/"+$(this).data("content"))
        });
    </script>
@endsection