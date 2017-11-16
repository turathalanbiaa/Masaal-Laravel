@foreach($question as $one_question)




    <div style="margin-left: 10px ; margin-right: 10px" class="ui  segment">
        <a class="ui large left corner label" data-action="share_question" data-id="{{$one_question->id}}">
            <i style="color: #00b5ad" class="share icon"></i>
        </a>
        <div class="ui grid">
            <div style="direction: ltr" class="column">
                @if($one_question->type == 1)
                    <a style="color: #00b5ad" class="ui right ribbon label">

                        الفقه->

                        الصلاه->

                        سؤال :{{$one_question->id}}

                    </a>

                @else

                @endif

            </div>

        </div>


        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">

                <div class="sub header">كرار حساني</div>
                <div class="sub header">{{$one_question->time}}</div>
            </div>


        </h3>

        <p>{{$one_question->content}}</p>
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <p class="ellipsis"
           style="line-height: 1.5em;height: 4.5em;overflow: hidden;text-overflow: ellipsis;">{{$one_question->answer}}</p>

        <a style="color: #00b5ad" href="/ar/single-question/{{$one_question->id}}" class="ui horizontal divider">
            تفاصيل اكثر
        </a>


        @if($one_question->image !="")


                <img class="ui centered bordered large image"
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


    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endforeach