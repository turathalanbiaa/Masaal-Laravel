<!DOCTYPE html>
<html lang="fr">

@include("fr.layout.head")

<body>
<div class="ui container">

    @include("fr.layout.page_header")

    <div class="ui hidden divider"></div>

    <div id="mobile-page-header" class="ui teal inverted segment">
        <div class="ui center aligned medium header">الاجوبة الميسّرة</div>
    </div>

    <div class="ui green segment">

        <div class="ui stackable two column very relaxed left aligned grid">

            <div class="column">

                <form method="post" action="/fr/login" class="ui form">
                    <h1 class="ui medium header">Log In</h1>
                    <div class="field">
                        <label>Username</label>
                        <div class="ui left icon input">
                            <input name="username" type="text" placeholder="Username" required>
                            <i class="user icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="ui left icon input">
                            <input name="password" type="password" placeholder="Password" required>
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    {{ csrf_field()}}
                    <button type="submit" class="ui large blue button">Login</button>
                </form>

            </div>

            <div class="column">

                <form method="post" action="/fr/register" class="ui form">
                    <h1 class="ui medium header">Sign Up</h1>

                    <div class="field">
                        <label>Name</label>
                        <div class="ui left icon input">
                            <input name="name" type="text" placeholder="Name" required>
                            <i class="user icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Email Or Phone Number</label>
                        <div class="ui left icon input">
                            <input name="emailOrPhone" placeholder="Email Or Phone" type="text" required>
                            <i class="text telephone icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="ui left icon input">
                            <input name="password" placeholder="Password" type="password">
                            <i class="lock icon"></i>
                        </div>
                    </div>

                    {{ csrf_field()}}

                    <button type="submit" class="ui large blue button">Create Account</button>
                </form>

            </div>

        </div>
    </div>

    <div class="ui hidden divider"></div>

</div>
</body>

</html>