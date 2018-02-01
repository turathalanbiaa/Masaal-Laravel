<!DOCTYPE html>
<html lang="en">

@include("en.layout.head")

<body>
<div class="ui container">

    @include("en.layout.page_header")

    <div class="ui hidden divider"></div>

    <div id="mobile-page-header" class="ui teal inverted segment">
        <div class="ui centered aligned medium header">Simplified Answers in Creeds and Jurisprudence
        </div>
    </div>

    <div class="ui stackable grid">

        <div class="eight wide  column">

            <div class="ui  centered green segment">


                    <div class="column">

                        <form method="post" action="/en/login" class="ui form">
                            {{ csrf_field()}}
            <h1 class="ui centered medium header">Type your info
            </h1>
            <div class="field">
                <label>Type your ID
                </label>
                <div class="ui right icon input">
                    <input name="username" type="text" placeholder="Type your ID
" required style="text-align: right">
                    <i class="user icon"></i>
                </div>
            </div>

            <div class="field">
                <label>Password
                </label>
                <div class="ui left icon input">
                    <input name="password" type="password" placeholder="Password
" required style="text-align: right">
                    <i class="lock icon"></i>
                </div>
            </div>

            <button type="submit" class="ui large blue button">Login</button>
        </form>




</div>
</div>

</div>


        <div class="eight wide  column">

            <div class="ui centered green segment">



                <div class="column">
                    <h1 class="ui centered medium header">Create
                    </h1>

                    @if(count($errors))
                        <div class="ui error message" id="message">
                            <ul class="list">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="/en/register" class="ui form">
                        {{ csrf_field()}}
                        <div class="field">
                            <label>الاسم</label>
                            <div class="ui left icon input">
                                <input name="name" type="text" placeholder="الاسم" style="text-align: right">
                                <i class="user icon"></i>
                            </div>
                        </div>

                        <div class="field">
                            <label>Create ID
                            </label>
                            <div class="ui left icon input">
                                <input name="username" placeholder=" مثل husain123 , ali2" type="text"
                                       style="text-align: right">
                                <i class="text telephone icon"></i>
                            </div>
                        </div>

                        <div class="field">
                            <label>Password
                            </label>
                            <div class="ui left icon input">
                                <input name="password" placeholder="Password
" type="password" style="text-align: right">
                                <i class="lock icon"></i>
                            </div>
                        </div>

                        {{ csrf_field()}}

                        <button type="submit" class="ui large blue button">Save</button>
                    </form>

                </div>

            </div>


        </div>

    </div>





</div>
</body>
<style>
    label {
        text-align: right;
    }
</style>
</html>