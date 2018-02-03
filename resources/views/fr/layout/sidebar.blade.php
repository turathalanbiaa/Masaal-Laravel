<div id="sidebar" style="direction:ltr">
    <div class="ui menu">
        <a class="item" onclick="$('.ui.sidebar').sidebar('toggle');" style="position:unset;">
            <i class="sidebar icon" style="color:#fff"></i>
        </a>
        <div class="mobile-header">
            <h3 class="ui large inverted center aligned header" id="mobile-vertical-center">الأجوبه الميسّره</h3>
        </div>
    </div>
    <div class="ui sidebar right inverted vertical borderless menu">
        <div class="ui horizontal inverted divider">
            الاجوبة الميسرة
        </div>
        <div class="item">
            <form method="post" action="/fr/search" class="ui icon input">
                {{ csrf_field() }}
                <input name="searchtext" type="text" placeholder="Chercher">
                <i class="search link icon"></i>
            </form>
        </div>
        <a class="item" href="/fr/index/1"> Questions jurispruden
        </a>
        <a class="item" href="/fr/index/2">Questions doctrinales
        </a>
        <a class="item" href="/fr/posts/1">Publications jurispruden
        </a>
        <a class="item" href="/fr/posts/2">Publications doctrinales
        </a>

        <div class="ui horizontal inverted divider">
            Par groupe
        </div>
        <a class="item" href="/fr/categories">Assujettir</a>
        <a class="item" href="/fr/tags">Catégories</a>


        <div class="ui horizontal inverted divider">
            Langue
        </div>
        <a class="item" href="/ar/app"><i class="circle icon"></i>عربي</a>
        <a class="item" href="/en/1"><i class="circle icon"></i>English</a>
        <div class="ui horizontal inverted divider">
            Un autre
        </div>
        <a class="item" href="/ar/send-question"><i class="large send icon"></i>Envoyer une question
        </a>
        <a class="item" href="/ar/my-questions"><i class="large mail icon"></i>Mes questions
        </a>

        <a class="item" href="/ar/app"><i class="large download icon"></i> Télécharger l'application</a>
        <div class="ui horizontal inverted divider">
            ...
        </div>
        <a href="/fr/login" class="item">Connexion
            <i class="sign in icon"></i>
        </a>
        <a class="item" href="/logout/"><i class="large log out icon"></i>déconnexion</a>
    </div>
</div>