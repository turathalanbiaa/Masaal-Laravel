<div id="sidebar" style="direction:ltr">
    <div class="ui menu">
        <a class="item" onclick="$('.ui.sidebar').sidebar('toggle');" style="position:unset;">
            <i class="sidebar icon" style="color:#fff"></i>
        </a>
        <div class="mobile-header">
            <h3 class="ui large inverted center aligned header" id="mobile-vertical-center">الأجوبه الميسّره</h3>
        </div>
    </div>
    <div class="ui sidebar right inverted vertical borderless menu">
        <div class="ui horizontal inverted divider">
            الاجوبة الميسرة
        </div>
        <div class="item">
            <form method="post" action="/fr/search" class="ui icon input">
                {{ csrf_field() }}
                <input name="searchtext" type="text" placeholder="ابحث عن كلمة في الاسئلة">
                <i class="search link icon"></i>
            </form>
        </div>
        <a class="item" href="/fr/index/1">الفقه الميسر</a>
        <a class="item" href="/fr/index/2">العقائد الميسر</a>
        <a class="item" href="/fr/posts/1">منشورات فقهية</a>
        <a class="item" href="/fr/posts/2">منشورات عقائديه</a>

        <div class="ui horizontal inverted divider">
            فرز حسب
        </div>
        <a class="item" href="/fr/categories">الاقسام</a>
        <a class="item" href="/fr/tags">المواضيع</a>


        <div class="ui horizontal inverted divider">
            اللغة
        </div>
        <a class="item" href="/ar/app"><i class="circle icon"></i>عربي</a>
        <a class="item" href="/en/1"><i class="circle icon"></i>English</a>
        <div class="ui horizontal inverted divider">
            اخرى
        </div>
        <a class="item" href="/ar/send-question"><i class="large send icon"></i>ارسال سؤال</a>
        <a class="item" href="/ar/my-questions"><i class="large mail icon"></i>اسئلتي</a>

        <a class="item" href="/ar/app"><i class="large download icon"></i>تحميل التطبيق</a>
        <div class="ui horizontal inverted divider">
            ...
        </div>
        <a href="/fr/login" class="item"> تسجيل دخول
            <i class="sign in icon"></i>
        </a>
        <a class="item" href="/logout/"><i class="large log out icon"></i>تسجيل خروج</a>
    </div>
</div>