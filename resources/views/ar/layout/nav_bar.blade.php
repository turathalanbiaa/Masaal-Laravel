<div id="nav" class="ui unstackable small menu">
    <a class="item" href="/ar/index/1">

        الفقه الميسر
    </a>
    <a class="item" href="/ar/index/2">
        العقائد الميسره
    </a>
    <a class="item" href="/ar/send-question">
        <i class="large send icon"></i> ارسال سؤال
    </a>
    <a class="item" href="/ar/my-questions">
        <i class="large mail icon"></i>
        اسئلتي
    </a>


    <div class="ui dropdown item">
        <i class="large browser icon"></i>
        <div class="text">المنشورات</div>
        <div class="menu">
            <a class="item" href="/ar/posts/1">منشورات فقهيه</a>
            <a class="item" href="/ar/posts/2">منشورات عقائديه</a>
        </div>
    </div>


    <div class="ui dropdown item">
        <i class="large tags icon"></i>
        فرز حسب

        <div class="ui vertical menu">


            <a class="item" href="/ar/tags">المواضيع</a>
            <a class="item" href="/ar/categories">الاقسام</a>

        </div>


    </div>


    <div class="item">
        <form method="post" action="/ar/search" class="ui icon input">
            {{ csrf_field() }}
            <input name="searchtext" type="text" placeholder="ابحث عن كلمة في الاسئلة">
            <i class="search link icon"></i>
        </form>
    </div>


    <div class="left menu">

        <div class="ui left dropdown item">
            <i class="large settings icon"></i>
            <div class="ui vertical menu">


                <div class="container">

                    <a href="/ar/index/1" class="item">عربي</a>
                    <a href="/en/index/1" class="item">English</a>

                    <a href="/fr/index/1" class="item">French</a>

                    <a class="item" href="/ar/app">
                        <i class="download icon"></i>
                        تحميل التطبيق
                    </a>
                    <a href="/logout" class="item"> تسجيل خروج
                        <i class="log out icon"></i>
                    </a>
                </div>

            </div>


        </div>


    </div>

</div>


<script>
    $('.ui.dropdown')
        .dropdown()
    ;

</script>