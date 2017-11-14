<div id="nav" class="ui small menu">
    <a class="item" href="/en/index">
        Home
    </a>
    <a class="item" href="/en/send-question">
        Send Question
    </a>
    <a class="item" href="/en/posts">
        Posts
    </a>
    <a class="item" href="/en/q-a">
        Q & A
    </a>
    <a class="item" href="/en/my-questions">
        My Question
    </a>
    <a class="item" href="/en/categories">
        Categories
    </a>
    <a class="item" href="/en/app">
        App
    </a>
    <div class="right menu">
        <div class="item">
            <form method="post" action="/en/search" class="ui icon input">
                {{ csrf_field() }}
                <input type="text" placeholder="Search...">
                <i class="search link icon"></i>
            </form>
        </div>
        <div class="item">
            <a href="/logout" class="ui primary button">
                Logout
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
