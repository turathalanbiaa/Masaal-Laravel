@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>Edit Answer</title>
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
                    <span>My Answers</span>
                </a>
                <a class="item active" href="/control-panel/respondent/my-answers">
                    <i class="folder open big icon" style="margin: 0;"></i>&nbsp;
                    <span>My Questions</span>
                </a>
                <a class="item" href="/control-panel/respondent/answers">
                    <i class="history big icon" style="margin: 0;"></i>&nbsp;
                    <span>Archives of Questions</span>
                </a>
            </div>
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("EnUpdateAnswerMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("EnUpdateAnswerMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui left aligned teal segment">
                <h3><span style="color: #21ba45;">Question:- </span> {{$question->content}}</h3>
                <form class="ui form" method="post" action="/control-panel/respondent/my-answers/{{$question->id}}/update-answer" enctype="multipart/form-data">
                    @csrf()

                    <div class="field">
                        <label for="answer">Answer</label>
                        <textarea name="answer" id="answer" placeholder="Type answer here...">{{$question->answer}}</textarea>
                    </div>

                    <div class="field">
                        <label for="category">Select Category</label>
                        <div class="ui fluid search selection dropdown" id="categories">
                            <input type="hidden" name="category" id="category">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">Search categories...</div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item" data-value="{{$category->id}}">{{$category->category}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tags">Select tag (tags)</label>
                        <div class="ui fluid multiple search selection dropdown" id="tags">
                            <input type="hidden" name="tags" id="tags">
                            <i class="dropdown icon"></i>
                            <input class="search">
                            <div class="default text">Search tags...</div>
                            <div class="menu">
                                @foreach($tags as $tag)
                                    <div class="item" data-value="{{$tag->id}}">{{$tag->tag}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="ten wide field">
                            <label for="image"  style="padding-left: 10px;">Image</label>
                            <input type="file" name="image" id="image" placeholder="Attach an image with the answer ... Optional">
                        </div>

                        <div class="six wide field" style="padding:0;" id="filed-card">
                            @if(!is_null($question->image))
                                <div class="ui fluid card" style="">
                                    <div class="blurring dimmable image">
                                        <div class="ui dimmer">
                                            <div class="content">
                                                <div class="center">
                                                    <button class="ui inverted red button" data-action="delete-image">Delete Image</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ui fluid bordered image">
                                            <img src="{{asset("storage/" . $question->image)}}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="field">
                        <label for="video-link">Video link (YouTube Video ID)</label>
                        <input type="text" name="videoLink" value="{{$question->videoLink}}" id="video-link" placeholder="Type youtube video id here... Optional">
                    </div>

                    <div class="field">
                        <label for="external-link">External link</label>
                        <input type="text" name="externalLink" value="{{$question->externalLink}}" id="external-link" placeholder="Type external link here... Optional">
                    </div>

                    <div class="field" style="text-align: center;">
                        <button type="submit" class="ui green button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });
        $('.ui.selection.dropdown#categories').dropdown("set selected", "{{$question->categoryId}}");
        $('.ui.selection.dropdown#tags').dropdown("set selected" ,[
            @foreach($question->QuestionTags as $questionTag)
                '{{$questionTag->tagId}}',
            @endforeach
        ]);

        //Remove image
        $('.ui.fluid.card .image').dimmer({
            on: 'hover'
        });
        $("button[data-action='delete-image']").click(function () {
            var h3 = "<h3 class='ui center aligned green header' width='100%'>Image deleted</h3>";
            var input = "<input type='hidden' name='delete' value='1'>";
            var filedCard = $("#filed-card").html(h3 + input);
        });
    </script>
@endsection