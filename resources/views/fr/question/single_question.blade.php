@extends("fr.layout.main")


@section("content")
    <div class="ui green segment">

        <a class="ui right tag label" href="/fr/index/{{$question->type}}">
            @if($question->type == 2)
                Doctrinale

                <a class="ui  teal tag label"
                   href="/fr/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @elseif($question->type == 1)

                Jurisprudence


                <a class="ui tag label"
                   href="/fr/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @endif

        </a>


        <a href="/fr/single-question/{{$question->id}}" class="ui right = label">Question:
            \ {{$question->id}}</a>

        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">
                <div class="sub header">{{$question->userDisplayName}}</div>
                <div class="sub header">{{$question->time}}</div>
            </div>


        </h3>

        <p>{{$question->content}}</p>
        <div class="ui divider"></div>
        <p>La réponse :</p>
        <p>{{$question->answer}}</p>


        <div class="ui hidden divider"></div>

        @if($question->image !="")
            <div class="ui  icon ">


                <img class="ui right bordered large image"
                     src="{{"/storage/" . $question->image}}">
            </div>
        @endif


        <div class="ui hidden divider"></div>


        @if($question->videoLink !="")
            <div>
                <br>
                <i class="video icon"></i>
                <label>vidéo : </label>
                <a  href="{{$question->videoLink}}">  Cliquez ici pour regarder la vidéo</a>



                {{--<div class="ui embed" data-url="{{$one_question->videoLink}}" data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}
                {{--<div class="ui embed" data-source="youtube" data-id="{{$one_question->videoLink}}" data-icon="play"--}}
                {{--data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}


            </div>
        @endif

        <div class="ui hidden divider"></div>

        @if($question->externalLink !="")
            <div class="ui icon">

                <i class="linkify icon"></i>
                <label>source : </label>
                <a target="_blank" href="{{$question->externalLink}}">Ajoutez ici pour visiter la source</a>
            </div>
        @endif


    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endsection