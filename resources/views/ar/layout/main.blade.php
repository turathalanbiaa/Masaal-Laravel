<!doctype html>
<html lang="ar">
<head>

    @include("ar.layout.head")

    @if(isset($page_title))
        <title>{{$page_title}}</title>
    @endif

</head>
<body class="pushable">


<div class="pusher">

    @include("ar.layout.sidebar")

    <div class="ui container">

        @include("ar.layout.page_header")

        @include("ar.layout.nav_bar")

        @yield("content")

    </div>
</div>

<div class="ui hidden divider"></div>

</body>
<script>$(".ui.dropdown").dropdown();</script>
@yield("script")
</html>