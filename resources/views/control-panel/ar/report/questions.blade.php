@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>{{$type ." - ". $category}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            <div class="ui segment">
                <h2 class="ui center aligned header">
                    <span>عدد الاسئلة</span>
                    <span>{{"(".$questions->count().")"}}</span>
                </h2>
                @forelse($questions as $question)
                    <p>
                        <span style="color: green">السؤال: </span>
                        <span>{{$question->content}}</span>
                    </p>

                    <p style="padding-bottom: 50px">
                        <span style="color: red">الجواب: </span>
                        <span>{{$question->answer}}</span>
                    </p>
                @empty
                    <h1 class="ui center aligned header">لاتوجد اسئلة</h1>
                @endforelse
            </div>
        </div>
    </div>
@endsection