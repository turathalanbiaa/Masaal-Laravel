@extends("ar.layout.main")

@section("content")
    <div class="ui green segment">
        <form method="post" action="/ar/send-question" class="ui form">
            <div class="field">
                <label>الرجاء أدخال السؤال :</label>
                <textarea rows="5" name="message"></textarea>
            </div>
            <div class="grouped fields">
                <label>ماهو نوع السؤال؟</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="type" checked="checked">
                        <label>خاص</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="type">
                        <label>عام</label>
                    </div>
                </div>
            </div>
            <div class="ui form">
                <div class="grouped fields">
                    <label>ماهو صنف السؤال؟</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="category" checked="checked">
                            <label>فقهي</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="category">
                            <label>عقائدي</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="category">
                            <label>لا اعرف</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <button class="ui large button">ارسال</button>

    </div>





@endsection