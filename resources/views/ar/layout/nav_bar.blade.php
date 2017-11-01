<div id="nav" class="ui small menu">
    <a class="item" href="/ar/index">
        الرئيسيه
    </a>
    <a class="item" href="/ar/send-question">
        ارسال سؤال
    </a>
    <a class="item" href="/ar/posts">
        المنشورات
    </a>
    <a class="item" href="/ar/q-a">
        الاستفتاءات
    </a>
    <a class="item" href="/ar/my-questions">
        اسئلتي
    </a>
    <a class="item" href="/ar/categories">
        التصنيفات
    </a>
    <a class="item" href="/ar/app">
        التطبيق
    </a>
    <div class="left menu">
        <div class="item">
            <form method="post" action="/ar/search" class="ui icon input">
                {{ csrf_field() }}
                <input type="text" placeholder="بحث...">
                <i class="search link icon"></i>
            </form>
        </div>
        <div class="item">
            <a href="/logout" class="ui primary button">
                تسجيل خروج
            </a>
        </div>
        <div class="ui dropdown item">
            اللغه
            <i style="margin-right:1em" class="dropdown icon"></i>
            <div class="menu">
                <a href="/en/index" class="item">English</a>
                <a href="/ar/index" class="item">عربي</a>
                <a href="/fr/index" class="item">French</a>
            </div>
        </div>
    </div>

</div>