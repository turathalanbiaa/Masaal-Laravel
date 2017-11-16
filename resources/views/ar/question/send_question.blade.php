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
        <div class="ui form">
            <div class="grouped fields">
                <label>سؤال فقهي</label>
                <div class="field">
                    <div class="ui left slider checkbox">
                        <input type="radio" name="throughput" checked="checked">
                        <label>سؤال عقائدي</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input type="radio" name="throughput">
                        <label>لا اعرف</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input type="radio" name="throughput">
                        <label>5mbps max</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox checked">
                        <input type="radio" name="throughput">
                        <label>Unmetered</label>
                    </div>
                </div>
            </div>
        </div>
        <button class="ui large button">ارسال</button>

    </div>

<script>

</script>



@endsection