@extends("cPanel.ar.layout.main_layout")

@section("title")
    <title>توزيع الاسئلة</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("cPanel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui right aligned segment">
                <div class="ui grid">
                    <div class="sixteen wide mobile twelve wide tablet fourteen wide computer column">
                        <table class="ui right aligned celled table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>السؤال</th>
                                <th>نوع السؤال</th>
                                <th colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{$question->id}}</td>
                                    <td>{{$question->content}}</td>
                                    <td>{{\App\Enums\QuestionType::getQuestionTypeName($question->type)}}</td>
                                    <td>
                                        <div class="ui selection dropdown">
                                            <input type="hidden" name="country">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Select Country</div>
                                            <div id="menu">
                                                <div class="item" data-value="af"><i class="af flag"></i>Afghanistan</div>
                                                <div class="item" data-value="ax"><i class="ax flag"></i>Aland Islands</div>
                                                <div class="item" data-value="al"><i class="al flag"></i>Albania</div>
                                                <div class="item" data-value="dz"><i class="dz flag"></i>Algeria</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{"ءىءء"}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script>
        $(".ui.selection").dropdown();

        $('.success.message').transition({
            animation  : 'flash',
            duration   : '1.5s'
        });
    </script>
@endsection