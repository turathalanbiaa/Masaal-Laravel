@if(Count($question)<=0)
    <div class="ui  segment">

        <div class="ui floating message">
            <p>No Data
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
            $questionContent = str_replace($searchtext, ' <mark>' . $searchtext . '</mark>', $one_question->content);
            ?>

            {!! $questionContent !!}
        @else
            <p>{{$one_question->content}}</p>

        @endif
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <p>
            @if($one_question->answer != null)

                {{$one_question->answer}}</p>
        @else
            <div class="ui  message"> Question Sent

                <br>We'll answer you question soon

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
                <label>video : </label>
                <a  href="{{$one_question->videoLink}}">Click here to see the video
                </a>



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
                <a target="_blank" href="{{$one_question->externalLink}}">Click here to go to the source
                </a>
            </div>
        @endif


        <div class="ui hidden divider">

        </div>

        <a class="ui right teal tag label" href="/en/index/{{$one_question->type}}">
            @if($one_question->type == 2)
                Ideological

                <a class="ui right teal tag label"
                   href="/en/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    @if($one_question->category!=null)
                        {{$one_question->category}}
                    @else
                        Without Category

                    @endif

                </a>
            @elseif($one_question->type == 1)

                Jurisprudential


                <a class="ui right teal tag label"
                   href="/en/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    @if($one_question->category!=null)
                        {{$one_question->category}}
                    @else
                        Without Category

                    @endif
                </a>
            @endif

        </a>
        <a href="/en/single-question/{{$one_question->id}}" class="ui right teal label">Question \ {{$one_question->id}}</a>
    </div>
    <script>
        $('.ui.embed').embed();
        $('.url.example .ui.embed').embed();
    </script>
@endforeach