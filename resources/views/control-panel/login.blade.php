<!doctype html>
<html>
<head>
<title>Login</title>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset("css/semantic.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/animate.css")}}">

    <!-- Script -->
    <script src="{{asset("/js/jquery-3.1.1.min.js")}}"></script>
    <script src="{{asset("/js/semantic.min.js")}}"></script>
</head>
<body>
    <div class="ui container">
        <div class="ui tiny modal">
            <h3 class="ui top attached grey inverted header">
                <span>Login To Control Panel</span>
            </h3>
            <div class="content">
                <div class="ui center aligned one column grid">
                    <div class="column">
                        <div class="ui small image">
                            <img src="{{asset("/img/logo.png")}}">
                        </div>
                    </div>
                </div>

                <div class="ui hidden divider"></div>
                <div class="ui divider"></div>
                <div class="ui hidden divider"></div>

                @if(count($errors))
                    <div class="ui error fadeInUp animated message" style="padding: 14px 0;">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session("ErrorLoginMessage"))
                    <div class="ui center aligned small bounce animated header">{{session("ErrorLoginMessage")}}</div>
                @endif

                @if(session("LogoutMessage"))
                    <div class="ui center aligned small bounce animated header">{{session("LogoutMessage")}}</div>
                @endif

                <form class="ui big form" dir="ltr" method="post" action="">
                    {!! csrf_field() !!}
                    <div class="field">
                        <input placeholder="Username" type="text" name="username" value="{{ old('username') }}">
                    </div>
                    <div class="field">
                        <input placeholder="Password" type="password" name="password">
                    </div>
                    <button type="submit" class="ui black fluid big button">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('.ui.modal').modal({
            centered: false,
            blurring: true,
            closable: false
        })
            .modal('show');
    </script>
</body>
</html>