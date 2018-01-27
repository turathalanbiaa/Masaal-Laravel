@extends("en.layout.main")

@section("content")
    <div class="ui green segment">

        <form method="post" action="/en/send" class="ui form">
            {!! csrf_field() !!}
            <div class="field">
                <label>الرجاء أدخال السؤال :</label>
                <textarea rows="5" name="message"></textarea>
            </div>
            <div class="ui centered error message"></div>
            <div class="grouped fields">
                <label>ماهو نوع السؤال؟</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input value="1" type="radio" name="privacy" checked="checked">
                        <label>خاص</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input value="2" type="radio" name="privacy">
                        <label>عام</label>
                    </div>
                </div>
            </div>
            <div class="ui form">
                <div class="grouped fields">
                    <label>ماهو صنف السؤال؟</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type" checked="checked">
                            <label>فقهي</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="2" type="radio" name="type">
                            <label>عقائدي</label>
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