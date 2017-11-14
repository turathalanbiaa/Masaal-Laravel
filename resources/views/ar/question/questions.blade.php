@extends("ar.layout.main")



@section("content")

    @if(isset($announcements))
        @include("ar.other.announcement" , ["announcements" => $announcements])
    @endif
    @foreach($questions as $question)
        <div id="questions">
            @include("ar.question.question" , ["question" => $question])

        </div>
    @endforeach

    <div class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            مشاركة السؤال على
        </div>
        <br><br>

        <div class="ui grid">
            <div class="five wide column">

                <a class="facebook"
                   href="https://www.facebook.com/sharer.php?u={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow" target="_blank"><i class="huge centered facebook icon"></i></a>


            </div>
            <div class="five wide column">

                <a class="twitter"
                   href="https://twitter.com/share?url={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow" target="_blank"><i class="huge centered twitter icon"></i></a>


            </div>
            <div class="five wide column">

                <a class="centered g-puls"
                   href="https://plus.google.com/u/0/share?url={{\Illuminate\Support\Facades\Request::root()}} . /single-question/"
                   rel="nofollow"
                   target="_blank">
                    <i class="huge centered google icon"></i></a>


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
            $("a.facebook").attr("href", href);
            $(".ui.modal").modal("show");
        });
    </script>
@endsection