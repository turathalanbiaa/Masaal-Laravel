<html>
<head>
    @include("ar.other.head")
</head>
<body>

@include("other.sidebar")

<div class="ui container">

    <div class="page-header">
        <h3 class="ui large inverted center aligned header" id="vertical-center">الأجوبه الميسّره</h3>
    </div>

    @include("other.navbar" ,
    ["username" => "علي" , "content" => "اني poomn "]
    )

    @yield("huda")



</div>

</body>

</html>
