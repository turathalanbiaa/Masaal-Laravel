<!doctype html>
<html lang="en">
<head>

    @include("en.layout.head")

    @if(isset($page_title))
        <title>{{$page_title}}</title>
    @endif

</head>
<body class="pushable">


<div class="pusher">

    @include("en.layout.sidebar")

    <div class="ui container">

        @include("en.layout.page_header")

        @include("en.layout.nav_bar")

        @yield("content")

    </div>
</div>

<div class="ui hidden divider"></div>

</body>
<script>$(".ui.dropdown").dropdown();</script>
@yield("script")
</html>