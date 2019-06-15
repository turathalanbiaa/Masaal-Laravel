@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>My Answers</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.en.layout.welcome")
        </div>

        <div class="column">
            <div class="ui four item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>Home</span>
                </a>
                <a class="item" href="/control-panel/respondent">
                    <i class="bars big icon" style="margin: 0;"></i>&nbsp;
                    <span>My Questions</span>
                </a>
                <a class="item active" href="/control-panel/respondent/my-answers">
                    <i class="folder open big icon" style="margin: 0;"></i>&nbsp;
                    <span>My Answers</span>
                </a>
                <a class="item" href="/control-panel/respondent/answers">
                    <i class="history big icon" style="margin: 0;"></i>&nbsp;
                    <span>Archives of Questions</span>
                </a>
            </div>
        </div>

        @if(session("EnUpdateAnswerMessage"))
            <div class="column">
                <div class="ui success message">
                    <h2 class="ui center aligned header">{{session("EnUpdateAnswerMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="column">
                <form class="ui big form" method="get" action="" dir="ltr">
                    <div class="ui icon input" style="width: 100%; text-align: right;">
                        <input type="text" name="q" placeholder="Search..." value="@if(isset($_GET["q"])){{$_GET["q"]}}@endif">
                        <i class="search icon"></i>
                    </div>
                    <div class="inline fields" style="margin-top: 10px;">
                        <label>In</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="t" value="1" tabindex="0" class="hidden" @if(isset($_GET["t"]) && $_GET["t"] == 1) checked @endif>
                                <label>Questions</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="t" value="2" tabindex="0" class="hidden" @if(isset($_GET["t"]) && $_GET["t"] == 2) checked @endif>
                                <label>Answers</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column">
            <div class="ui right aligned segments">
                @forelse($questions as $question)
                    <div class="ui teal segment">
                        <div class="ui dimmer">
                            <div class="ui text loader">Loading...</div>
                        </div>

                        <p style="font-weight: bold;">
                            <span>user</span>
                            <span> :- </span>
                            <span style="color: #00b5ad;">{{$question->User["name"]}}</span>
                        </p>

                        <p>
                            <span style="color: #21ba45;">Question :- </span>
                            <span>{{$question->content}}</span>
                        </p>

                        <p>
                            <span style="color: #b5cc18;">Answer :- </span>
                            <span>{{$question->answer}}</span>
                        </p>

                        <p>
                            @if($question->status == \App\Enums\QuestionStatus::TEMP_ANSWER)
                                <span style="color: red;">The question under review</span>
                            @else
                                <span style="color: red;">Question posted</span>
                            @endif
                        </p>

                        <div class="ui accordion">
                            <div class="title">
                                <i class="dropdown icon"></i>
                                <span>more details</span>
                            </div>
                            <div class="content">
                                <p>
                                    <span>Category</span>
                                    <i class="long arrow right icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(!is_null($question->Category))
                                        <span>Not found</span>
                                    @else
                                        <span>{{$question->Category->category}}</span>
                                    @endif
                                </p>

                                <p>
                                    <span>Tags</span>
                                    <i class="long arrow right icon" style="font-size: medium; font-weight: bold;"></i>
                                    @forelse($question->QuestionTags as $questionTag)
                                        @if($loop->last)
                                            <span>{{$questionTag->Tag->tag}}</span>
                                            @break
                                        @endif
                                        <span>{{$questionTag->Tag->tag . " *** "}}</span>
                                    @empty
                                        <span>Not found</span>
                                    @endforelse
                                </p>

                                <p>
                                    <span>Video Link</span>
                                    <i class="long arrow right icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(is_null($question->videoLink))
                                        <span>Not found</span>
                                    @else
                                        <a target="_blank" href="https://www.youtube.com/watch?v={{$question->videoLink}}">https://www.youtube.com/watch?v={{$question->videoLink}}</a>
                                    @endif
                                </p>

                                <p>
                                    <span>External Link</span>
                                    <i class="long arrow right icon" style="font-size: medium; font-weight: bold;"></i>
                                    @if(is_null($question->externalLink))
                                        <span>Not found</span>
                                    @else
                                        <a target="_blank" href="{{$question->externalLink}}">{{$question->externalLink}}</a>
                                    @endif
                                </p>

                                <div>
                                    <span>Photo</span>
                                    @if(!is_null($question->image))
                                        <i class="long arrow down icon" style="font-size: medium; font-weight: bold;"></i><br>
                                        <div class="ui medium bordered rounded image">
                                            <img src="{{ asset("storage/".$question->image)}}">
                                        </div>
                                    @else
                                        <i class="long arrow right icon" style="font-size: medium; font-weight: bold;"></i>
                                        <span>Not found</span>
                                    @endif
                                </div>

                                <div class="ui divider"></div>
                            </div>
                        </div>

                        <div class="ui hidden divider"></div>

                        <a class="ui inverted blue button" href="/control-panel/respondent/my-answers/{{$question->id}}/edit-answer">Edit Answer</a>
                    </div>
                @empty
                    <div class="ui segment">
                        <div class="ui massive info message">
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui center aligned header">There are no questions</div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                        </div>
                    </div>
                @endforelse

                @if($questions->hasPages())
                    <div class="ui center aligned segment">
                        @if(isset($_GET["q"]) && isset($_GET["t"]))
                            {{$questions->appends(['t' => $_GET["t"], 'q' => $_GET["q"]])->links("pagination::semantic-ui")}}
                        @else
                            {{$questions->links("pagination::semantic-ui")}}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $('.ui.radio.checkbox').checkbox();
        $('.ui.accordion').accordion();
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
    </script>
@endsection