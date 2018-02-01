<div id="sidebar" style="direction:ltr">
    <div class="ui menu">
        <a class="item" onclick="$('.ui.sidebar').sidebar('toggle');" style="position:unset;">
            <i class="sidebar icon" style="color:#fff"></i>
        </a>
        <div class="mobile-header">
            <h3 class="ui large inverted center aligned header" id="mobile-vertical-center">Simplified Answers in Creeds and Jurisprudence
            </h3>
        </div>
    </div>
    <div class="ui sidebar right inverted vertical borderless menu">
        <div class="ui horizontal inverted divider">
            الاجوبة الميسرة
        </div>
        <div class="item">
            <form method="post" action="/en/search" class="ui icon input">
                {{ csrf_field() }}
                <input name="searchtext" type="text" placeholder="Search">
                <i class="search link icon"></i>
            </form>
        </div>
        <a class="item" href="/en/index/1">Jurisprudential Questions
        </a>
        <a class="item" href="/en/index/2"> Ideological Questions
        </a>
        <a class="item" href="/en/posts/1">Jurisprudential Posts
        </a>
        <a class="item" href="/en/posts/2"> Ideological Posts
        </a>

        <div class="ui horizontal inverted divider">
            فرز حسب
        </div>
        <a class="item" href="/en/categories">الاقسام</a>
        <a class="item" href="/en/tags">المواضيع</a>


        <div class="ui horizontal inverted divider">
            اللغة
        </div>
        <a class="item" href="/ar/app"><i class="circle icon"></i>عربي</a>
        <a class="item" href="/en/1"><i class="circle icon"></i>English</a>
        <a class="item" href="/fr/1"><i class="circle icon"></i>French</a>
        <div class="ui horizontal inverted divider">
            اخرى
        </div>
        <a class="item" href="/en/send-question"><i class="large send icon"></i> Send Your Question
        </a>
        <a class="item" href="/en/my-questions"><i class="large mail icon"></i> My Questions
        </a>

        <a class="item" href="/en/app"><i class="large download icon"></i>Download App</a>
        <div class="ui horizontal inverted divider">
            ...
        </div>
        <a href="/en/login" class="item">Login
            <i class="sign in icon"></i>
        </a>
        <a class="item" href="/logout/"><i class="large log out icon"></i>Logout</a>
    </div>
</div>