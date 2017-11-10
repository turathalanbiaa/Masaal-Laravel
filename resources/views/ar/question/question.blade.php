@foreach($question as $one_question)




    <div class="ui green segment">
        <p>سؤال رقم : {{$one_question->id}}</p>
        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">

                <div class="sub header">كرار حساني</div>
                <div class="sub header">{{$one_question->time}}</div>
            </div>


        </h3>

        <h3>{{$one_question->content}}</h3>
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <h3>{{$one_question->answer}}</h3>


        <div class="ui hidden divider"></div>

        @if($one_question->image !="")
            <div class="ui  icon ">

                <i class="centered image icon"></i>
                <label>الصورة</label>
                <br>
                <img class="ui centered bordered large image" src="{{\App\Enums\ImagePath::path_answer . $one_question->image}}">
            </div>
            @endif


        <div class="ui hidden divider"></div>


        @if($one_question->videoLink !="")
        <div class="ui icon">
            <i class="video icon"></i>
            <label>الفيديو</label>
            <br>

            <iframe width="100%" height="100%"
                    src="{{$one_question->videoLink}}"
                    frameborder="0" gesture="media" allowfullscreen></iframe>
        </div>
        @endif

        <div class="ui hidden divider"></div>

        @if($one_question->externalLink !="")
        <div class="ui icon">

            <i class="linkify icon"></i>
            <label>المصدر : </label>
            <a href="{{$one_question->externalLink}}">اضفط
                هنا لزيارة المصدر</a>
        </div>
        @endif

        <div class="ui hidden divider"></div>

        <button class="ui icon button">
            <i class="share icon"></i>
            <label>مشاركة</label>
        </button>

    </div>

@endforeach