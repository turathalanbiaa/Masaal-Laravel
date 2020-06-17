@if(Count($questions)<=0)
    <div class="ui  segment">

        <div class="ui floating message">
            <p>لاتوجد اسئلة</p>
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
تصفح
<a class="ui right teal  label">


    @if(isset($my_type))
        @if($my_type == 2)
            العقائد

        @elseif($my_type == 1)

            الفقه


        @elseif($my_type == 0)

            جميع الاسئلة


        @elseif($my_type == 3)

            القرآن الكريم


        @elseif($my_type == 4)

            اجتماعي

        @elseif($my_type == 30)

            اسئلتي

        @elseif($my_type == 31)

            نتائج البحث

        @elseif($my_type == 32)

            بواسطة المواضيع

        @elseif($my_type == 33)

            بواسطة الاقسام



        @endif
    @endif


</a>


@foreach($questions as $one_question)


    <div class="ui  segment">

        @if($my_type == 0)


            <a class="ui right teal tag label" href="/ar/index/{{$one_question->type}}">


                @if($one_question->type == 2)
                    العقائد

                @elseif($one_question->type == 1)

                    الفقه


                @elseif($one_question->type == 3)

                    القرآن الكريم


                @elseif($one_question->type == 4)

                    اجتماعي


                @endif

            </a>
        @endif

        <a class="ui right  tag label"
           href="/ar/search?type={{$one_question->type}}&id={{$one_question->categoryId}}">
            @if($one_question->category!=null)
                {{$one_question->category}}
            @else
                غير مصنف
            @endif
        </a>
        <a href="/ar/single-question/{{$one_question->id}}" class="ui right  label">س \ {{$one_question->id}}</a>


        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">


                <div class="sub header">{{$one_question->userDisplayName}}</div>
                @if(isset($one_question->x))
                    <div class="sub header">{{$one_question->x}}</div>

                @elseif(isset($one_question->time))
                    <div class="sub header">{{$one_question->time}}</div>

                @endif


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
            <p style="height:60px; line-height:20px;  overflow:hidden;">{{$one_question->content}}</p>

        @endif
        <div class="ui divider"></div>

        @if($one_question->answer != null)



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


        @else
            <div class="ui  message"> تم ارسال السؤال
                <br>

                سوف تتم الاجابة قريبا

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
                <label>الفيديو : </label>
                <a href="{{$one_question->videoLink}}"> اضغظ هنا لمشاهدة الفيديو</a>


                {{--<div class="ui embed" data-url="{{$one_question->videoLink}}" data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}
                {{--<div class="ui embed" data-source="youtube" data-id="{{$one_question->videoLink}}" data-icon="play"--}}
                {{--data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}


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


        <a href="/ar/single-question/{{$one_question->id}}" class="ui right  label">
            <i class=" comment icon"> </i>
            التعليقات
            <i style="font-size: 14px" class=" circle green icon"> </i>

        </a>


    </div>
    <script>
        $('.ui.embed').embed();
        $('.url.example .ui.embed').embed();
        $('.ui.accordion')
            .accordion()
        ;
    </script>

@endforeach