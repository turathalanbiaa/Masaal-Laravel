<div id="nav" class="ui small menu">
    <a class="item" href="index.html">
        Maison
    </a>
    <a class="active item" href="posts.html">
        Des Postes
    </a>
    <a class="item" href="Q-A.html">
        Q&amp;A
    </a>
    <a class="item" href="my-question.html">
        Ma Question
    </a>
    <a class="item" href="send-question.html">
        Send Question
    </a>
    <a class="item" href="catogaries.html">
        Catogaries
    </a>
    <a class="item" href="App.html">
        App
        <div>
            <h1>person</h1>
            <p>{{$username}}</p>
            <h1>question is</h1>
            <p>{{$content}}</p>
        </div>
    </a>
    <div class="right menu">
        <div class="item">
            <form action="research-results.html" class="ui icon input">
                <input type="text" placeholder="chercher...">
                <i class="search link icon"></i>
            </form>
        </div>
        <div class="item">
            <div class="ui primary button">
                Connectez-Out
            </div>
        </div>
        <div class="ui dropdown item" tabindex="0">
            La langue
            <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
                <a class="item">English</a>
                <a class="item">عربي</a>
                <a class="item">French</a>
            </div>
        </div>
    </div>
</div>