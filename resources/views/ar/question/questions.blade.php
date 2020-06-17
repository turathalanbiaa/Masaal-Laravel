@extends("ar.layout.main")



@section("content")

    @if(isset($announcements))
        @include("ar.other.announcement" , ["announcements" => $announcements])
    @endif

    <div id="questions">

     
        @include("ar.question.question" , ["questions" => $questions])
        <div style="margin-top: 30px" class="ui center aligned stackable grid">

            @if(isset($unlink))

            @else
                {!! $questions->links() !!}

            @endif

        </div>
        <br><br><br><br><br><br>
    </div>


    <div class="ui tiny modal">
        <i class="close icon"></i>
        <div class=" header">
            مشاركة السؤال على
        </div>
        <br><br>

        <div class="ui grid">
            <div class="five wide column">

                <a class="facebook"
                   href="https://www.facebook.com/sharer.php?u=masael.turathalanbiaa.com/ar/single-question/"
                   rel="nofollow" target="_blank"><i class="big centered facebook icon"></i>Facebook</a>


            </div>
            <div class="five wide column">

                <a class="twitter"
                   href="https://twitter.com/share?url=masael.turathalanbiaa.com/ar/single-question/"
                   rel="nofollow" target="_blank"><i class="big centered twitter icon"></i>Twitter</a>


            </div>
            <div class="five wide column">

                <a class="g-puls"
                   href="https://plus.google.com/u/0/share?url=masael.turathalanbiaa.com/ar/single-question/"
                   rel="nofollow"
                   target="_blank">
                    <i class="big centered google icon"></i>google plus</a>


            </div>

            <div class="four wide column"></div>
        </div>

        <div style="margin-top: 30px" class="ui center aligned stackable grid">



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