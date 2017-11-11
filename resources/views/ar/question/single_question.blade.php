@extends("ar.layout.main")


@section("content")
    <div class="ui green segment">

        <div class="ui centered statistics">
            <div class="statistic">
                <div class="value">

                    <a class="facebook"
                       href="https://www.facebook.com/sharer.php?u={{Request::url()}}&amp;title={{$question->title}}"
                       rel="nofollow" target="_blank"><i class="facebook icon"></i></a>

                </div>
                <div class="label">
                    facebook
                </div>
            </div>
            <div class="statistic">
                <div class="value">
                    <a class="twitter"
                       href="https://twitter.com/share?url={{Request::url()}}&amp;title={{$question->title}}"
                       rel="nofollow" target="_blank"><i class="twitter icon"></i></a>
                </div>
                <div class="label">
                    twitter
                </div>
            </div>
            <div class="statistic">
                <div class="value">
                    <a class="centered g-puls" href="https://plus.google.com/u/0/share?url={{Request::url()}}"
                       rel="nofollow"
                       target="_blank">
                        <i class="centered google icon"></i></a>

                </div>
                <div class="label">
                    google-plus
                </div>
            </div>
        </div>


        <h3>سؤال رقم : {{$question->id}}</h3>
        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">

                <div class="sub header">كرار حساني</div>
                <div class="sub header">{{$question->time}}</div>
            </div>


        </h3>

        <p>{{$question->content}}</p>
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <p>{{$question->answer}}</p>


        <div class="ui hidden divider"></div>

        @if($question->image !="")
            <div class="ui  icon ">

                <i class="centered image icon"></i>
                <label>الصورة</label>
                <br>
                <img class="ui centered bordered large image"
                     src="{{\App\Enums\ImagePath::path_answer . $question->image}}">
            </div>
        @endif


        <div class="ui hidden divider"></div>


        @if($question->videoLink !="")
            <div class="ui icon">
                <i class="video icon"></i>
                <label>الفيديو</label>
                <br>


                <div class="ui embed" data-source="youtube" data-id="{{$question->videoLink}}" data-icon="play"
                     data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>


            </div>
        @endif

        <div class="ui hidden divider"></div>

        @if($question->externalLink !="")
            <div class="ui icon">

                <i class="linkify icon"></i>
                <label>المصدر : </label>
                <a target="_blank" href="{{$question->externalLink}}">اضفط
                    هنا لزيارة المصدر</a>
            </div>
        @endif


    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endsection