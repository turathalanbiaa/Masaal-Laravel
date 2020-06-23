@extends("ar.layout.main")


@section("content")
    <a class="ui left  tag label" href="/ar/index/{{$question->type}}">


        @if($question->type == 2)
            العقائد

        @elseif($question->type == 1)

            الفقه


        @elseif($question->type == 3)

            القرآن الكريم


        @elseif($question->type == 4)

            اجتماعي


        @endif

    </a>


    <a class="ui left  tag label"
       href="/ar/search?type={{$question->type}}&id={{$question->categoryId}}">
        @if($question->category!=null)
            {{$question->category}}
        @else
            غير مصنف
        @endif
    </a>
    <a href="/ar/single-question/{{$question->id}}" class="ui left  label">س \ {{$question->id}}</a>

    <div class="ui centered green segment">
        <div class="ui  accordion" style="text-align: left">
            <div class="title  active">
                مشاركة
                <i class=" share green icon"></i>

            </div>
            <div class="content ">
                <p class="transition visible" style="display: block !important;">

                <div class="ui five column centered grid  bordered">


                    <div class=" row">
                        <div class=" column">
                            <a href="https://www.facebook.com/sharer.php?u=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                               rel="nofollow" target="_blank">
                                فيسبوك
                                <i class="big centered facebook icon"></i></a>


                        </div>
                        <div class="column">

                            <a href="https://www.instagram.com/?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                               target="_blank" rel="nofollow">
                                انستغرام
                                <i class="big instagram icon"></i></a>

                        </div>

                        <div class="column">

                            <a href="https://telegram.me/share/url?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                               target="_blank" rel="nofollow">
                                تيليغرام
                                <i class="big telegram icon"></i></a>

                        </div>
                        <div class=" column">
                            <a href="https://twitter.com/share?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"
                               rel="nofollow" target="_blank">
                                تويتر
                                <i class="big centered twitter icon"></i></a>

                        </div>
                        {{--                        <div class="column">--}}
                        {{--                            <a href="https://plus.google.com/u/0/share?url=masael.turathalanbiaa.com/ar/single-question/{{$question->id}}"--}}
                        {{--                               rel="nofollow"--}}
                        {{--                               target="_blank">--}}
                        {{--                                --}}
                        {{--                                <i class="big centered google icon"></i></a>--}}

                        {{--                        </div>--}}


                    </div>
                    <div class="ui section divider"></div>
                </div>


                </p>

            </div>

        </div>


        <br>


        <h3 class="ui header" style="margin-top: -20px">
            {{--            <img src="/img/man.jpg">--}}
            <div class="content ">

                <div class="sub header">{{$question->userDisplayName}}</div>
                <div class="sub header">{{$question->time}}</div>


            </div>


        </h3>

        <p>{{$question->content}}</p>
        <div class="ui divider"></div>
        <p>الجواب :</p>
        <p>{{$question->answer}}</p>


        <div class="ui compact menu">

            <a onclick=" this.style.background = '#64d97c'" class="item">
                <i  class="medium green  thumbs up icon"></i> مفيد

            </a>
        </div>
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


        <div class="ui comments">
            <h3 class="ui dividing header"><a href="/ar/refresh/{{$question->id }}">
                    <i class="icon refresh"></i>
                </a>التعليقات</h3>
            @foreach($comments as $comment)
                @if($comment->type == 2)
                    <div class="comment ">
                        <div class="content">
                            <i class="green small circle icon">
                            </i>
                            <a class="author green">الادارة</a>
                            <div class="metadata">
                                <span class="date">{{$comment->date_time}}</span>
                            </div>
                            <div class="text">
                                <p>{{$comment->content}}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="comment">
                        <div class="content">
                            <a class="author">{{$comment->username}}</a>
                            <div class="metadata">
                                <span class="date">{{$comment->date_time}}</span>
                            </div>
                            <div class="text">
                                {{$comment->content}}
                                @if ( Cookie::get('USER_ID') == $comment->user_id)
                                    <a class="ui label" href="/ar/delete_comment/{{$question->id}}/{{$comment->comment_id}}">حذف
                                        <i class="delete icon"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            @if (Cookie::get('SESSION'))
                <form method="post" action="/ar/insert_comment/{{$question->id }}" class="ui form">
                    {!! csrf_field() !!}
                    <div class="field">
                        <textarea name="content" required  style="max-height: 30px"></textarea>
                    </div>
                    <button type="submit" class="ui blue labeled submit icon button">
                        <i class="icon edit"></i> اضافة تعليق
                    </button>
                </form>
            @else
                <p>لاضافة تعليق يرجى تسجيل الدخول او انشاء حساب <a href="/ar/login">اضفط هنا</a>
                </p>
            @endif
        </div>

    </div>

    <script>
        $('.ui.embed').embed();
        $('.ui.accordion')
            .accordion()
        ;

        $(document).ready(function () {
            $('html,body').animate({scrollTop: document.body.scrollHeight}, "slow");
        })
        document.getElementById('liked_btn').onclick = changeColor;

        function changeColor() {
            document.body.style.color = "purple";
            return false;
        }
        $('.ui.form')
            .form({
                fields: {
                    name     : 'empty',
                    gender   : 'empty',
                    username : 'empty',
                    password : ['minLength[6]', 'empty'],
                    skills   : ['minCount[2]', 'empty'],
                    terms    : 'checked'
                }
            })
        ;
    </script>

@endsection