@foreach($question as $one_question)




    <div class="ui green segment">
        <h3>سؤال رقم : {{$one_question->id}}</h3>
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
        <p>{{$one_question->answer}}</p>


        <div class="ui hidden divider"></div>

        @if($one_question->image !="")
            <div class="ui  icon ">

                <i class="centered image icon"></i>
                <label>الصورة</label>
                <br>
                <img class="ui centered bordered large image"
                     src="{{\App\Enums\ImagePath::path_answer . $one_question->image}}">
            </div>
        @endif



        <div class="ui hidden divider"></div>


        @if($one_question->videoLink !="")
            <div class="ui icon">
                <i class="video icon"></i>
                <label>الفيديو</label>
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

        <a href="/ar/single-question/{{$one_question->id}}" class="ui icon button">
            <i class="share icon"></i>
            <label>فتح المنشور</label>
        </a>

    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endforeach