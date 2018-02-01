@extends("en.layout.main")

@section("content")
    <div class="ui green segment">

        <form method="post" action="/en/send" class="ui form">
            {!! csrf_field() !!}
            <div class="field">
                <label>Write Your Question
                    :</label>
                <textarea rows="5" name="message"></textarea>
            </div>
            <div class="ui centered error message"></div>
            <div class="grouped fields">
                <label> Privacy
                    ؟</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input value="1" type="radio" name="privacy" checked="checked">
                        <label> Private
                        </label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input value="2" type="radio" name="privacy">
                        <label> Public
                        </label>
                    </div>
                </div>
            </div>
            <div class="ui form">
                <div class="grouped fields">
                    <label>Category
                        ؟</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type" checked="checked">
                            <label> Jurisprudence
                            </label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="2" type="radio" name="type">
                            <label>Ideological

                            </label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type">
                            <label> I do not know
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="ui green large button">Send
            </button>

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
                                prompt: 'please enter your Question'
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