@extends("en.layout.main")

@section("content")
    <div class="ui green segment">
        <form method="post" action="/en/send-question" class="ui form">

            <div class="field">
                <label>Write your question :</label>
                <textarea rows="5" name="message"></textarea>
            </div>

            <div class="grouped fields">
                <label>Privacy</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="type" checked="checked">
                        <label>Private</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="type">
                        <label>Public</label>
                    </div>
                </div>
            </div>

            <div class="grouped fields">
                <label>Category</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="catogary" checked="checked">
                        <label>فقهي</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="catogary">
                        <label>عقائدي</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" name="catogary">
                        <label>لا اعرف</label>
                    </div>
                </div>
            </div>

            <button class="ui large button">Send</button>

        </form>

    </div>
@endsection