<!DOCTYPE html>
<html lang="ar">

@include("ar.layout.head")

<body>
<div class="ui container">

    @include("ar.layout.page_header")

    <div class="ui hidden divider"></div>

    <div id="mobile-page-header" class="ui teal inverted segment">
        <div class="ui centered aligned medium header">الاجوبة الميسّرة</div>
    </div>

    <div class="ui centered green segment">

        <div class="ui centered stackable two column very relaxed left aligned grid">

            <div class="column">

                <form method="post" action="/ar/login" class="ui form">
                    <h1 class="ui centered medium header">تسجيل الدخول</h1>
                    <div class="field">
                        <label>رقم الهاتف او الايميل</label>
                        <div class="ui right icon input">
                            <input  name="username" type="text" placeholder="رقم الهاتف او الايميل" required style="text-align: right">
                            <i class="user icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>رمز المرور</label>
                        <div class="ui left icon input">
                            <input name="password" type="password" placeholder="ادخل رمز المرور هنا" required style="text-align: right">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    {{ csrf_field()}}
                    <button type="submit" class="ui large blue button">دخول</button>
                </form>

            </div>



        </div>
    </div>
    <h4 class="ui centered">اذا كنت لاتمتلك حساب - انشأه الان</h4>

    <div class="ui centered green segment">

        <div class="ui centered stackable two column very relaxed left aligned grid">



            <div class="column">
                <h1 class="ui centered medium header">انشاء حساب جديد</h1>

                <form method="post" action="/ar/register" class="ui form">

                    <div class="field">
                        <label >الاسم</label>
                        <div class="ui left icon input">
                            <input name="name" type="text" placeholder="الاسم" required style="text-align: right">
                            <i class="user icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>رقم الهاتف او الايميل</label>
                        <div class="ui left icon input">
                            <input name="emailOrPhone" placeholder="رقم الهاتف او الايميل" type="text" required style="text-align: right">
                            <i class="text telephone icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>رمز المرور</label>
                        <div class="ui left icon input">
                            <input name="password" placeholder="رمز المرور" type="password" style="text-align: right">
                            <i class="lock icon"></i>
                        </div>
                    </div>

                    {{ csrf_field()}}

                    <button type="submit" class="ui large blue button">انشاء الحساب</button>
                </form>

            </div>

        </div>
    </div>

    <div class="ui hidden divider"></div>

</div>
</body>
<style>
    label{
        text-align: right;
    }
</style>
</html>