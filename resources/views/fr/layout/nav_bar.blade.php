<div id="nav" class="ui small menu">
    <a class="item" href="/fr/index">
        Maison
    </a>
    <a class="item" href="/fr/send-question">
        Send Question
    </a>
    <a class="item" href="/fr/posts">
        Posts
    </a>
    <a class="item" href="/fr/q-a">
        Q & A
    </a>
    <a class="item" href="/fr/my-questions">
        My Question
    </a>
    <a class="item" href="/fr/categories">
        Categories
    </a>
    <a class="item" href="/fr/app">
        App
    </a>
    <div class="right menu">
        <div class="item">
            <form method="post" action="/fr/search" class="ui icon input">
                {{ csrf_field() }}
                <input type="text" placeholder="Search...">
                <i class="search link icon"></i>
            </form>
        </div>
        <div class="item">
            <a href="/logout" class="ui primary button">
                Connectez_out
            </a>
        </div>
        <div class="ui dropdown item">
            Language
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="/en/index/1" class="item">English</a>
                <a href="/ar/index/1" class="item">عربي</a>
                <a href="/fr/index/1" class="item">French</a>
            </div>
        </div>
    </div>

</div>
