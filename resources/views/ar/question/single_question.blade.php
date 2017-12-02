@extends("ar.layout.main")


@section("content")
    <div class="ui green segment">

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
                     src="{{\App\Enums\ImagePath::path_answer . $question->image}}">
            </div>
        @endif


        <div class="ui hidden divider"></div>


        @if($question->videoLink !="")
            <div class="ui icon">

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