@extends("fr.layout.main")



@section("content")

    @if(isset($announcements))
        @include("fr.other.announcement" , ["announcements" => $announcements])
    @endif
    @foreach($questions as $question)
        <div id="questions">
            @include("fr.question.question" , ["question" => $question])

        </div>
    @endforeach

    <div class="ui tiny modal">
        <i class="close icon"></i>
        <div class=" header">
            مشاركة السؤال على
        </div>
        <br><br>

        <div class="ui grid">
            <div class="five wide column">
                Facebook
                <a class="facebook"
                   href="https://www.facebook.com/sharer.php?u={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow" target="_blank"><i class="big centered facebook icon"></i></a>


            </div>
            <div class="five wide column">
                Twitter
                <a class="twitter"
                   href="https://twitter.com/share?url={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow" target="_blank"><i class="big centered twitter icon"></i></a>


            </div>
            <div class="five wide column">
                google plus
                <a class="centered g-puls"
                   href="https://plus.google.com/u/0/share?url={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow"
                   target="_blank">
                    <i class="big centered google icon"></i></a>


            </div>
            <div class="four wide column"></div>
        </div>


    </div>

@endsection

@section("script")
    <script>
        $("a[data-action=share_question]").click(function () {
            var id = $(this).data("id");
            var href = $("a.facebook").attr("href") + id;
            var href2 = $("a.twitter").attr("href") + id;
            var href3 = $("a.g-puls").attr("href") + id;
            $("a.facebook").attr("href", href);
            $("a.twitter").attr("href", href2);
            $("a.g-puls").attr("href", href3);
            $(".ui.modal").modal("show");
        });
    </script>
@endsection