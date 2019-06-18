@extends("control-panel.en.layout.main_layout")

@section("title")
    <title>Distribute Questions</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.en.layout.welcome")
        </div>

        <div class="column">
            <div class="ui two item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>Home</span>
                </a>
                <a class="item active" href="/control-panel/distributor">
                    <i class="recycle big icon" style="margin: 0;"></i> &nbsp;
                    <span>Distribute Questions</span>
                </a>
            </div>
        </div>

        <div class="column">
            <div class="ui right aligned segments">
                @forelse($questions as $question)
                    <div class="ui teal segment">
                        <div class="ui dimmer" id="dimmer">
                            <div class="ui text loader">Loading...</div>
                        </div>

                        <p style="font-weight: bold;">
                            <span>user</span>
                            <span> :- </span>
                            <span style="color: #00b5ad;">{{$question->User->name}}</span>
                        </p>

                        <p>
                            <span style="color: #21ba45;">Question :- </span>
                            <span>{{$question->content}}</span>
                        </p>
                        <div class="ui divider"></div>
                        <div class="ui form">
                            <input type="hidden" name="questionId" value="{{$question->id}}">
                            <div class="sixteen wide field">
                                <div class="ui selection dropdown" style="width: 100%;">
                                    <input type="hidden" name="respondentId">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Select Responder</div>
                                    <div class="menu">
                                        @foreach($respondents as $respondent)
                                            <div class="item" data-value="{{$respondent->id}}">
                                                {{$respondent->name}}
                                                <div class="ui label">
                                                    <div class="detail" style="margin: 0;">{{$respondent->questionsUnanswered()->count()}}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="sixteen wide field">
                                <button class="ui inverted green button" data-action="distribute-question">Convert To Respondent</button>
                                <button class="ui inverted red button" data-action="delete-question" data-content="{{$question->id}}">Delete</button>
                                <button class="ui inverted blue button" data-action="change-type-question" data-content="{{$question->id}}">
                                    @if($question->type == \App\Enums\QuestionType::FEQHI)
                                        <span>Convert To Jurisprudence</span>
                                    @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                                        {{"Convert To Ideology"}}
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ui segment">
                        <div class="ui massive info message">
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui center aligned header">There are no new questions to distribute</div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                            <div class="ui hidden divider"></div>
                        </div>
                    </div>
                @endforelse

                @if($questions->hasPages())
                    <div class="ui center aligned segment">
                        {{$questions->links("pagination::semantic-ui")}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section("extra-content")
    <div class="ui mini modal" id="modal-delete-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">Are you sure you want to delete the question?</span>
        </h3>
        <div class="content">
            <input type="hidden" name="question">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button">Yes</button>
                <button class="ui negative button">No</button>
            </div>
        </div>
    </div>

    <div class="ui mini modal" id="modal-change-type-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">Are you sure you want to change the type of question?</span>
        </h3>
        <div class="content">
            <input type="hidden" name="question">
            <div class="actions" style="text-align: center;">
                <button class="ui positive button">Yes</button>
                <button class="ui negative button">No</button>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $(".ui.selection.dropdown").dropdown();

        //Distribute the question
        $("button[data-action='distribute-question']").click(function () {
            var button = $(this);

            var questionId = button.parent().parent().find("input[type='hidden'][name='questionId']").val();
            var respondentId = button.parent().parent().find("input[type='hidden'][name='respondentId']").val();

            var currentDimmer = button.parent().parent().parent().find('#dimmer');
            currentDimmer.addClass("active");

            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/control-panel/distributor/distribute-question/ajax',
                data: {questionId:questionId, respondentId:respondentId},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("There is no such question" , 3000 , "warning");

                    else if(result["respondent"] === "NotFound")
                        snackbar("Respondent not selected" , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("The question has not been forwarded to the respondent, please try again" , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("The question has been successfully converted to the respondent" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("Check internet connection" , 3000 , "error");
                } ,
                complete : function() {
                    currentDimmer.removeClass("active");

                    if(success)
                    {
                        //Hidden segment
                        setTimeout(function(){
                            var segment = button.parent().parent().parent();
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);

                        //Increment unanswered question counter
                        var count = $("div[data-value='" + respondentId + "']").find(".detail").html();
                        $("div[data-value='" + respondentId + "']").find(".detail").html(++count);
                    }
                }
            });
        });

        //Delete the question
        $("button[data-action='delete-question']").click(function () {
            var button = $(this);
            button.parent().parent().parent().attr("id", "current-segment");
            button.addClass("loading");
            $("#modal-delete-question input[name='question']").val(button.data("content"));
            $("#modal-delete-question")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });
        $("#modal-delete-question button.positive.button").click(function () {
            var dimmer = $("#current-segment .dimmer");
            dimmer.addClass("active");

            var question = $(this).parent().parent().find("input[name='question']").val();
            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/control-panel/distributor/delete-question/ajax",
                data: {question: question},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("There is no such question" , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("The question has not been deleted, try again" , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("Question successfully deleted" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("Check internet connection" , 3000 , "error");
                } ,
                complete : function() {
                    var segment = $("#current-segment");
                    segment.removeAttr("id");
                    segment.find("button[data-action='delete-question']").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });

        //Change type the question
        $("button[data-action='change-type-question']").click(function () {
            var button = $(this);
            button.parent().parent().parent().attr("id", "current-segment");
            button.addClass("loading");
            $("#modal-change-type-question input[name='question']").val(button.data("content"));
            $("#modal-change-type-question")
                .modal({
                    'closable' : false,
                    'transition': 'horizontal flip'
                })
                .modal("show");
        });
        $("#modal-change-type-question button.positive.button").click(function () {
            var dimmer = $("#current-segment .dimmer");
            dimmer.addClass("active");

            var question = $(this).parent().parent().find("input[name='question']").val();
            var success = false;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/control-panel/distributor/change-type-question/ajax",
                data: {question: question},
                datatype: 'json',
                success: function(result) {
                    if (result["question"] === "NotFound")
                        snackbar("There is no such question" , 3000 , "warning");

                    else if (result["success"] === false)
                        snackbar("The question type is not changed, try again" , 3000 , "error");

                    else if (result["success"] === true)
                    {
                        snackbar("Question type changed successfully" , 3000 , "success");
                        success = true;
                    }
                },
                error: function() {
                    snackbar("Check internet connection" , 3000 , "error");
                } ,
                complete : function() {
                    var segment = $("#current-segment");
                    segment.removeAttr("id");
                    segment.find("button[data-action='change-type-question']").removeClass("loading");
                    if(success)
                    {
                        setTimeout(function () {
                            segment.addClass("scale");
                            segment.transition({
                                animation  : 'scale',
                                duration   : '1s'
                            });
                        }, 250);
                    }
                }
            });
        });

        $("button.negative.button").click(function () {
            var segment = $("#current-segment");
            segment.removeAttr("id");
            segment.find("button[data-action='delete-question']").removeClass("loading");
            segment.find("button[data-action='change-type-question']").removeClass("loading");
        });
    </script>
@endsection