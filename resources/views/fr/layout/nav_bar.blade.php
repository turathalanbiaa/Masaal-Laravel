<div class="ui  two column centered grid ">

    <div style="margin-top: 20px" class="equal width row">

        <div class="center aligned column">

            <a href="/fr/index/2">
                <img style="width: 150px ; color: #ffffff" src="/img/d2.png">
            </a>

        </div>
        <div class="center aligned column">
            <a href="/fr/index/1">
                <img style="width: 150px ; color: #ffffff" src="/img/d1.png">

            </a>

        </div>
    </div>

</div>
<br>

<div id="nav" class="ui  small menu">

    <a style="direction: ltr" class="item" href="/fr/send-question">
        <i class="large send icon"></i> Envoyer une question

    </a>
    <a style="direction: ltr" class="item" href="/fr/my-questions">
        <i class="large mail icon"></i>
        Mes questions

    </a>


    <div  style="direction: ltr" class="ui dropdown item">
        <i  class="large browser icon"></i>
        Publications
        <div class="ui vertical menu">
            <div class="container">
                <a style="text-align: center"  class="item" href="/fr/posts/1">Publications jurispruden
                </a>
                <a style="text-align: center"   class="item" href="/fr/posts/2">Publications doctrinales
                </a>
            </div>
        </div>
    </div>


    <div style="direction: ltr ; margin: 0px" class="ui dropdown item">
        <i class="large tags icon"></i>

        Par groupe
        <div class="ui vertical menu">

            <div class="container">
                <a style="text-align: center"  class="item" href="/fr/tags">Assujettir</a>

                <a style="text-align: center"  class="item" href="/fr/categories">Catégories</a>
            </div>
        </div>


    </div>


    <div class="item">
        <form method="post" action="/ar/search" class="ui icon input">
            {{ csrf_field() }}
            <input name="searchtext" type="text" placeholder="Chercher
">
            <i class="search link icon"></i>
        </form>
    </div>


    <div class="right menu">

        <div class="ui right dropdown item">
            <i class="large translate icon"></i>
            <div class="ui vertical menu">


                <div class="container">

                    <a style="text-align: center" href="/ar/index/1" class="item">عربي</a>
                    <a style="text-align: center" href="/en/index/1" class="item">English</a>


                </div>

            </div>


        </div>
        <div class="ui left dropdown item">
            <i class="large list layout icon"></i>
            <div class="ui vertical menu">

                <a style=" margin: 20px;text-align: center" href="http://turathalanbiaa.com/"  class="ui primary basic button">
                    <i class="right arrow icon"></i>
                    Turath Alanbiaa
                </a>
                <div class="container">



                    <a style="text-align: center" class="item" href="/ar/app">
                        <i class="download icon"></i>
                        Télécharger l'application
                    </a>
                    <a style="text-align: center" href="/fr/login" class="item">Connexion
                        <i class="sign in icon"></i>
                    </a>
                    <a style="text-align: center" href="/fr/logout" class="item">déconnexion
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