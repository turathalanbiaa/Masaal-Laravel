

    <div class="ui five item menu">
        <a class=" item" href="/ar/index/0">جميع الاسئلة</a>
        <a class="item" href="/ar/index/1">الفقه</a>
        <a class="item" href="/ar/index/2">العقائد </a>
        <a class="item" href="/ar/index/3">القرآن الكريم </a>
        <a class="item" href="/ar/index/4"> اجتماعية</a>
    </div>

<br>

<div id="nav" class="ui  small menu">

    <a style="direction: ltr" class="item" href="/ar/send-question">
        <i class="large send icon"></i> ارسال سؤال
    </a>
    <a style="direction: ltr" class="item" href="/ar/my-questions">
        <i class="large mail icon"></i>
        اسئلتي
    </a>


    <div style="direction: ltr" class="ui dropdown item">
        <i class="large browser icon"></i>
        المنشورات
        <div class="ui vertical menu">
            <div class="container">
                <a style="text-align: center" class="item" href="/ar/posts/1">منشورات فقهيه</a>
                <a style="text-align: center" class="item" href="/ar/posts/2">منشورات عقائديه</a>
                <a style="text-align: center" class="item" href="/ar/posts/3">منشورات قرآنيه</a>
                <a style="text-align: center" class="item" href="/ar/posts/4">منشورات اجتماعيه</a>
            </div>
        </div>
    </div>


    <div style="direction: ltr ; margin: 0px" class="ui dropdown item">
        <i class="large tags icon"></i>

        فرز حسب
        <div class="ui vertical menu">

            <div class="container">
                <a style="text-align: center" class="item" href="/ar/tags">المواضيع</a>

                <a style="text-align: center" class="item" href="/ar/categories">الاقسام</a>
            </div>
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
            <i class="large translate icon"></i>
            <div class="ui vertical menu">


                <div class="container">


                    <a style="text-align: center" href="/en/index/1" class="item">English</a>

                    <a style="text-align: center" href="/fr/index/1" class="item">French</a>

                </div>

            </div>


        </div>
        <div class="ui left dropdown item">
            <i class="large list layout icon"></i>
            <div class="ui vertical menu">

                <a style=" margin: 20px;text-align: center" href="http://turathalanbiaa.com/"
                   class="ui primary basic button">
                    <i class="right arrow icon"></i>
                    معهد تراث الانبياء
                </a>
                <div class="container">


                    <a style="text-align: center" class="item" href="/ar/app">
                        <i class="download icon"></i>
                        تحميل التطبيق
                    </a>
                    <a style="text-align: center" href="/ar/login" class="item"> تسجيل دخول
                        <i class="sign in icon"></i>
                    </a>
                    <a style="text-align: center" href="/ar/logout" class="item"> تسجيل خروج
                        <i class="log out icon"></i>
                    </a>
                </div>

            </div>


        </div>


    </div>

</div>

<div class="ui grid">

    <div style="direction: ltr" class="eight wide column">


    </div>
    <div style="direction: ltr" class="eight wide column">


    </div>


</div>

<script>
    $('.ui.dropdown')
        .dropdown()
    ;

</script>