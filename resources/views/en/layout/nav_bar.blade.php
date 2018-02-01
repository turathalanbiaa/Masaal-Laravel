<div class="ui two column centered grid ">

    <div style="margin-top: 20px" class="equal width row">

        <div class="center aligned column">

            <a href="/en/index/2">
                <img style="width: 150px ; color: #ffffff" src="/img/d2.png">
            </a>

        </div>
        <div class="center aligned column">
            <a href="/en/index/1">
                <img style="width: 150px ; color: #ffffff" src="/img/d1.png">

            </a>

        </div>
    </div>

</div>
<br>

<div id="nav" class="ui  small menu">

    <a style="direction: ltr" class="item" href="/en/send-question">
        <i class="large send icon"></i>  Send Your Question

    </a>
    <a style="direction: ltr" class="item" href="/en/my-questions">
        <i class="large mail icon"></i>
        My Questions

    </a>


    <div style="direction: ltr" class="ui dropdown item">
        <i class="large browser icon"></i>
        Posts
        <div class="ui vertical menu">
            <div class="container">
                <a style="text-align: center" class="item" href="/en/posts/1">Jurisprudential Posts
                </a>
                <a style="text-align: center" class="item" href="/en/posts/2"> Ideological Posts
                </a>
            </div>
        </div>
    </div>


    <div style="direction: ltr ; margin: 0px" class="ui dropdown item">
        <i class="large tags icon"></i>

        فرز حسب
        <div class="ui vertical menu">

            <div class="container">
                <a style="text-align: center" class="item" href="/en/tags">Subjects
                </a>

                <a style="text-align: center" class="item" href="/en/categories">Divisions
                </a>
            </div>
        </div>


    </div>


    <div class="item">
        <form method="post" action="/en/search" class="ui icon input">
            {{ csrf_field() }}
            <input name="searchtext" type="text" placeholder="Search">
            <i class="search link icon"></i>
        </form>
    </div>


    <div class="right menu">

        <div class="ui left dropdown item">
            <i class="large translate icon"></i>
            <div class="ui vertical menu">


                <div class="container">
                   <a style="text-align: center" href="/ar/index/1" class="item">عربي</a>

                    <a style="text-align: center" href="/fr/index/1" class="item">French</a>

                </div>

            </div>


        </div>
        <div class="ui left dropdown item">
            <i class="large list layout icon"></i>
            <div class="ui vertical menu">

                <a style=" margin: 20px;text-align: center" href="http://turathalanbiaa.com/"
                   class="ui primary basic button">
                    <i class="right arrow icon"></i>
                    Turath Alanbiaa
                </a>
                <div class="container">


                    <a style="text-align: center" class="item" href="/en/app">
                        <i class="download icon"></i>
                       Dounload App
                    </a>
                    <a style="text-align: center" href="/en/login" class="item">login
                        <i class="sign in icon"></i>
                    </a>
                    <a style="text-align: center" href="/en/logout" class="item">logout
                        <i class="log out icon"></i>
                    </a>
                </div>

            </div>


        </div>


    </div>

</div>

<div class="ui grid">

    <div style="direction: ltr" class="eight wide column">


    </div>
    <div style="direction: ltr" class="eight wide column">


    </div>


</div>

<script>
    $('.ui.dropdown')
        .dropdown()
    ;

</script>