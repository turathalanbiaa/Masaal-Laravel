@extends("control-panel.en.layout.main_layout")

@section("title")
<title>My Questions</title>
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
            <a class="item active" href="/control-panel/respondent">
                <i class="bars big icon" style="margin: 0;"></i>&nbsp;
                <span>My Questions</span>
            </a>
            <a class="item" href="/control-panel/respondent/my-answers">
                <i class="folder open big icon" style="margin: 0;"></i>&nbsp;
                <span>My Answers</span>
            </a>
            <a class="item" href="/control-panel/respondent/answers">
                <i class="history big icon" style="margin: 0;"></i>&nbsp;
                <span>Archive of Questions</span>
            </a>
        </div>
    </div>

    @if(session("EnAnswerQuestionMessage"))
        <div class="column">
            <div class="ui success message">
                <h2 class="ui center aligned header">{{session("EnAnswerQuestionMessage")}}</h2>
            </div>
        </div>
    @endif

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
                        <span style="color: #00b5ad;">{{$question->User->name}}</span>
                    </p>

                    <p>
                        <span style="color: #21ba45;">Question :- </span>
                        <span>{{$question->content}}</span>
                    </p>

                    <div class="ui divider"></div>

                    <a class="ui inverted green button" href="/control-panel/respondent/{{$question->id}}/edit">Answer</a>
                    <button class="ui inverted red button" data-action="delete-question" data-content="{{$question->id}}">Delete</button>
                    <button class="ui inverted orange button" data-action="return-question" data-content="{{$question->id}}">Return to distributor</button>
                    <button class="ui inverted blue button" data-action="change-type-question" data-content="{{$question->id}}">
                        @if($question->type == \App\Enums\QuestionType::FEQHI)
                            <span>Convert To Jurisprudence</span>
                        @elseif($question->type == \App\Enums\QuestionType::AKAEDI)
                            <span>Convert To Ideology</span>
                        @endif
                    </button>
                </div>
            @empty
                <div class="ui segment">
                    <div class="ui massive info message">
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                        <div class="ui hidden divider"></div>
                        <div class="ui center aligned header">There are no new questions</div>
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

    <div class="ui mini modal" id="modal-return-question">
        <h3 class="ui center aligned top attached inverted header">
            <span style="color: white;">Are you sure you will return the question to the distributor?</span>
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
    $('.ui.message').transition({
        animation  : 'flash',
        duration   : '1s'
    });

    //Delete the question
    $("button[data-action='delete-question']").click(function () {
        var button = $(this);
        button.parent().attr("id", "current-segment");
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
            url: "/control-panel/respondent/delete-question/ajax",
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

    //Return the question
    $("button[data-action='return-question']").click(function () {
        var button = $(this);
        button.parent().attr("id", "current-segment");
        button.addClass("loading");
        $("#modal-return-question input[name='question']").val(button.data("content"));
        $("#modal-return-question")
            .modal({
                'closable' : false,
                'transition': 'horizontal flip'
            })
            .modal("show");
    });
    $("#modal-return-question button.positive.button").click(function () {
        var dimmer = $("#current-segment .dimmer");
        dimmer.addClass("active");

        var question = $(this).parent().parent().find("input[name='question']").val();
        var success = false;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/control-panel/respondent/return-question/ajax",
            data: {question: question},
            datatype: 'json',
            success: function(result) {
                if (result["question"] === "NotFound")
                    snackbar("There is no such question" , 3000 , "warning");

                else if (result["success"] === false)
                    snackbar("The question has not been returned to the distributor, please try again" , 3000 , "error");

                else if (result["success"] === true)
                {
                    snackbar("The question has been successfully returned to the distributor" , 3000 , "success");
                    success = true;
                }
            },
            error: function() {
                snackbar("Check internet connection" , 3000 , "error");
            } ,
            complete : function() {
                var segment = $("#current-segment");
                segment.removeAttr("id");
                segment.find("button[data-action='return-question']").removeClass("loading");
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
        button.parent().attr("id", "current-segment");
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
            url: "/control-panel/respondent/change-type-question/ajax",
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
        segment.find("button[data-action='return-question']").removeClass("loading");
        segment.find("button[data-action='delete-question']").removeClass("loading");
        segment.find("button[data-action='change-type-question']").removeClass("loading");
    });
</script>
@endsection