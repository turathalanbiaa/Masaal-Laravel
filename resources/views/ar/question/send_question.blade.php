@extends("ar.layout.main")

@section("content")
    <div class="ui green segment">

        <form method="post" action="/ar/send" class="ui form">
            {!! csrf_field() !!}
            <div class="field">
                <label>الرجاء أدخال السؤال :</label>
                <textarea rows="5" name="message"></textarea>
            </div>
            <div class="ui centered error message"></div>
            <div class="grouped fields">
                <label>ماهو نوع السؤال؟</label>
                <div class="field">


                    <div class="ui right pointing label"  >


                    <div class="inline field"  >

                        <div class="ui radio checkbox">
                            <input value="2" type="radio" name="privacy" checked="checked">
                            <label>عام</label>
                        </div>
                         سوف تجد الاجابة على سؤالك في الاسئلة العامة و تجده ايضاً في قسم اسئلتي
                        </div>
                    </div>

                    <div class="ui right pointing label" style="margin-top: 20px">



                        <div class="inline field">

                            <div class="ui radio checkbox">
                                <input value="1" type="radio" name="privacy" >
                                <label>خاص</label>
                            </div>

                            يجب انشاء حساب قبل ارسال سؤال خاص -اضغط هنا
                            <a style="text-align: center" href="/ar/login" > تسجيل دخول</a> </div>



                    </div>

                </div>

            </div>
            <div class="ui form">
                <div class="grouped fields">
                    <label>ماهو صنف السؤال؟</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type" checked="checked">
                            <label>فقه</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="2" type="radio" name="type">
                            <label>عقائد</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="3" type="radio" name="type">
                            <label>القرآن الكريم</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="4" type="radio" name="type">
                            <label>اجتماعية</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type">
                            <label>لا اعرف</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="ui green large button">ارسال</button>

        </form>


    </div>

    <script>
        $('.ui.checkbox').checkbox();
        $('.ui.form')
            .form({
                fields: {
                    message: {
                        identifier: 'message',
                        rules: [
                            {
                                type: 'minLength[6]',
                                prompt: 'يرجى كتابة سؤال كامل'
                            }
                        ]
                    }

                }
            })
        ;
    </script>

<script>
    $('.ui.embed').embed();
</script>

@endsection