<!doctype html>
<html>
<head>
    @yield("title")

    <!-- meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{asset("css/semantic.min.css")}}">
        <link rel="stylesheet" type="text/css" href="{{asset("css/cp_ar_style.css")}}">
        <link rel="stylesheet" type="text/css" href="{{asset("css/animate.css")}}">
        <link rel="stylesheet" type="text/css" href="{{asset("css/snackbar.css")}}">

    <!-- Script -->
        <script src="{{asset("/js/jquery-3.1.1.min.js")}}"></script>
        <script src="{{asset("/js/semantic.min.js")}}"></script>
        <script src="{{asset("/js/snackbar.js")}}"></script>
</head>
<body>
    <div class="ui container">
        @yield("content")
    </div>

    @yield("extra-content")

    @yield("script")
</body>
</html>