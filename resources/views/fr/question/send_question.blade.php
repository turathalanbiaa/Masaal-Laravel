@extends("fr.layout.main")

@section("content")
    <div class="ui green segment">

        <form method="post" action="/fr/send" class="ui form">
            {!! csrf_field() !!}
            <div class="field">
                <label>Tapez votre question

                    :</label>
                <textarea rows="5" name="message"></textarea>
            </div>
            <div class="ui centered error message"></div>
            <div class="grouped fields">
                <label> Confidentialité

                    ؟</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input value="1" type="radio" name="privacy" checked="checked">
                        <label> Privé

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
                    <label>Sélectionner une classification

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
                            <label>Doctrinales


                            </label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="1" type="radio" name="type">
                            <label>pas de réponses

                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="ui green large button">Envoyer une question

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