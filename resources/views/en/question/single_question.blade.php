@extends("en.layout.main")


@section("content")
    <div class="ui green segment">

        <a class="ui right tag label" href="/en/index/{{$question->type}}">
            @if($question->type == 2)
                Ideological

                <a class="ui  teal tag label"
                   href="/en/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @elseif($question->type == 1)

                Jurisprudential


                <a class="ui tag label"
                   href="/en/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @endif

        </a>


        <a href="/en/single-question/{{$question->id}}" class="ui right = label">Question \ {{$question->id}}</a>

        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">
                <div class="sub header">{{$question->userDisplayName}}</div>
                <div class="sub header">{{$question->time}}</div>
            </div>


        </h3>

        <p>{{$question->content}}</p>
        <div class="ui divider"></div>
        <p>Answer :</p>
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
                <label>video : </label>
                <a  href="{{$question->videoLink}}">Click here to see the video
                </a>



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
                <a target="_blank" href="{{$question->externalLink}}">Click here to go to the source
                </a>
            </div>
        @endif


    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endsection