<!doctype html>
<html lang="fr">
<head>

    @include("fr.layout.head")

    @if(isset($page_title))
        <title>{{$page_title}}</title>
    @endif

</head>
<body class="pushable">


<div class="pusher">

        @include("fr.layout.sidebar")

        <div class="ui container">

                @include("fr.layout.page_header")

                @include("fr.layout.nav_bar")

                @yield("content")

        </div>
</div>

<div class="ui hidden divider"></div>

</body>
<script>$(".ui.dropdown").dropdown();</script>
</html>