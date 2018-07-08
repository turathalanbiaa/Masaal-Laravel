@extends("ar.layout.main")


@section("content")
    <div class="ui centered green segment">


        <div class="ui centered grid">

            <br><br>
            مشاركة المسألة على


            <div class="three centered column row">
                <div class="column">
                    <a

                            href="https://www.facebook.com/sharer.php?u=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                            rel="nofollow" target="_blank"><i class="big centered facebook icon"></i>facebook</a>

                    <br>
                </div>
                <div class="column">
                    <a
                            href="https://twitter.com/share?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                            rel="nofollow" target="_blank"><i class="big centered twitter icon"></i>Twitter</a>
                    <br>
                </div>
                <div class="column">
                    <a
                            href="https://plus.google.com/u/0/share?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                            rel="nofollow"
                            target="_blank">
                        <i class="big centered google icon"></i>g-puls</a>

                </div>
            </div>

        </div>


        <br>
        <br>
        <br>


        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content ">
                <div class="sub header">{{$question->userDisplayName}}</div>
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


                <img class="ui right bordered large image"
                     src="{{"/storage/" . $question->image}}">
            </div>
        @endif


        <div class="ui hidden divider"></div>


        @if($question->videoLink !="")
            <div>
                <br>
                <i class="video icon"></i>
                <label>الفيديو : </label>
                <a href="{{$question->videoLink}}"> اضغظ هنا لمشاهدة الفيديو</a>


                {{--<div class="ui embed" data-url="{{$one_question->videoLink}}" data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}
                {{--<div class="ui embed" data-source="youtube" data-id="{{$one_question->videoLink}}" data-icon="play"--}}
                {{--data-placeholder="{{\App\Enums\ImagePath::path_post . "green.png"}}"></div>--}}


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

        <a class="ui right tag label" href="/ar/index/{{$question->type}}">
            @if($question->type == 2)
                العقائد
                <a class="ui  teal tag label"
                   href="/ar/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @elseif($question->type == 1)

                الفقه

                <a class="ui tag label"
                   href="/ar/search?type={{$question->type}}&id={{$question->categoryId}}">
                    {{$question->category}}


                </a>
            @endif

        </a>


        <a href="/ar/single-question/{{$question->id}}" class="ui right = label">س \ {{$question->id}}</a>

    </div>
    <script>
        $('.ui.embed').embed();
    </script>
@endsection