@if(Count($question)<=0)

    <div class="ui floating message">
        <p>لاتوجد اسئلة</p>
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


    <div style="margin-left: 10px ; margin-right: 10px" class="ui  segment">


        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">

                <div class="sub header">{{$one_question->userDisplayName}}</div>
                <div class="sub header">{{$one_question->time}}</div>
            </div>


        </h3>
        <a class="ui large left corner label" data-action="share_question" data-id="{{$one_question->id}}">
            <i style="color: #00b5ad" class="share icon"></i>
        </a>
        @if(isset($searchtext))
            <?php
            $questionContent = str_replace($searchtext, ' <mark>' . $searchtext . '</mark>', $one_question->content);
            ?>

            {!! $questionContent !!}
        @else
            <p class="ellipsis"
               style="line-height: 1.5em;height: 4.5em;overflow: hidden;text-overflow: ellipsis;">{{$one_question->content}}</p>

        @endif
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <p class="ellipsis">{{$one_question->answer}}</p>


        @if($one_question->image !="")


            <img class="ui right bordered large image"
                 src="{{\App\Enums\ImagePath::path_answer . $one_question->image}}">

        @endif


        @if($one_question->videoLink !="")
            <div>
                <br>


                <div class="ui embed" data-source="youtube" data-id="{{$one_question->videoLink}}" data-icon="play"
                     data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>


            </div>
        @endif

        <div class="ui hidden divider"></div>

        @if($one_question->externalLink !="")
            <div class="ui icon">

                <i class="linkify icon"></i>
                <label>المصدر : </label>
                <a target="_blank" href="{{$one_question->externalLink}}">اضفط
                    هنا لزيارة المصدر</a>
            </div>
        @endif

        <div class="ui hidden divider">

        </div>

        <a class="ui right teal tag label" href="/ar/index/{{$one_question->type}}">
            @if($one_question->type == 2)
                العقائد
                <a class="ui right teal tag label"
                   href="/ar/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    {{$one_question->category}}


                </a>
            @elseif($one_question->type == 1)

                الفقه

                <a class="ui right teal tag label"
                   href="/ar/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
                    {{$one_question->category}}


                </a>
            @endif

        </a>


        <a href="/ar/single-question/{{$one_question->id}}" class="ui right teal label">س \ {{$one_question->id}}</a>


    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endforeach