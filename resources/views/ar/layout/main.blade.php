<!doctype html>
<html lang="ar">
<head>

    @include("ar.layout.head")

    <title>الأجوبة الميسرة</title>

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



</body>
<script>$(".ui.dropdown").dropdown();</script>
@yield("script")
</html>