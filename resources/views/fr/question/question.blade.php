@if(Count($question)<=0)
    <div class="ui  segment">

        <div class="ui floating message">
            <p>Pas de donnés
            </p>
        </div>
    </div>

@endif
<style>
    mark {
        background-color: yellow;
        text-anchor: true;
        color: black;
    }
</style>
@foreach($question as $one_question)


    <div class="ui  segment">


        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">

                <div class="sub header">{{$one_question->userDisplayName}}</div>
                <div class="sub header">{{$one_question->time}}</div>
            </div>


        </h3>
        <a class="ui large right corner label" data-action="share_question" data-id="{{$one_question->id}}">
            <i style="color: #00b5ad" class="share icon"></i>
        </a>
        @if(isset($searchtext))
            <?php
            $questionAnswer = str_replace($searchtext, ' <mark>' . $searchtext . '</mark>', $one_question->answer);
            ?>
            {!! $questionAnswer !!}
        @else
            <div style="height: auto">
                <p style="height: 4em; white-space: normal; overflow: hidden;  text-overflow: ellipsis;"> {{$one_question->answer}}</p>
            </div>

            <p>
                ... <a href="/ar/single-question/{{$one_question->id}}" class="ui right ">اكمال القراءة</a></p>

        @endif
        <div class="ui divider"></div>
        <p>La réponse :</p>
        <p>
            @if($one_question->answer != null)

                {{$one_question->answer}}</p>
        @else
            <div class="ui  message">Question envoyée

                <br>

                La réponse sera bientôt disponible

            </div>
            ً
        @endif

        @if($one_question->image !="")


            <img class="ui right bordered large image"
                 src="{{\App\Enums\ImagePath::path_answer . $one_question->image}}">

        @endif


        @if($one_question->videoLink !="")
            <div>
                <br>
                <i class="video icon"></i>
                <label>Vidéo : </label>
                <a  href="{{$one_question->videoLink}}"> Cliquez ici pour regarder la vidéo</a>



                {{--<div class="ui embed" data-url="{{$one_question->videoLink}}" data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}
                {{--<div class="ui embed" data-source="youtube" data-id="{{$one_question->videoLink}}" data-icon="play"--}}
                {{--data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}


            </div>
        @endif

        <div class="ui hidden divider"></div>

        @if($one_question->externalLink !="")
            <div class="ui icon">

                <i class="linkify icon"></i>
                <label>source : </label>
                <a target="_blank" href="{{$one_question->externalLink}}">Ajoutez ici pour visiter la source</a>
            </div>
        @endif


        <div class="ui hidden divider">

        </div>

        <a class="ui right teal tag label" href="/fr/index/{{$one_question->type}}">
            @if($one_question->type == 2)
                Doctrinales

                <a class="ui right teal tag label"
                   href="/fr/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    @if($one_question->category!=null)
                        {{$one_question->category}}
                    @else
                        Sans classification

                    @endif

                </a>
            @elseif($one_question->type == 1)

                Jurispuridence


                <a class="ui right teal tag label"
                   href="/fr/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    @if($one_question->category!=null)
                        {{$one_question->category}}
                    @else
                        Sans classification

                    @endif
                </a>
            @endif

        </a>
        <a href="/fr/single-question/{{$one_question->id}}" class="ui right teal label">Question \ {{$one_question->id}}</a>
    </div>
    <script>
        $('.ui.embed').embed();
        $('.url.example .ui.embed').embed();
    </script>
@endforeach