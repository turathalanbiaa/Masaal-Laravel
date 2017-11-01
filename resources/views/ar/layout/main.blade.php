<!doctype html>
<html lang="ar">
<head>
    @include("ar.layout.head")

</head>
<body>
    @include("ar.layout.sidebar")

    <div class="ui container">

        @include("ar.layout.page_header")

        @include("ar.layout.nav_bar")

        @yield("content")



    </div>
<div class="ui hidden divider"></div>



</body>
<script>$(".ui.dropdown").dropdown();</script>
</html>