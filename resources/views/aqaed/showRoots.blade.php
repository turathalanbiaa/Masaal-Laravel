@extends("CPanel.ar.layout.main_layout")

@section("title")

    <title>المرجع العقائدي</title>

@endsection

@section("content")
    @foreach($subjects as $subject)
    <div class="ui green segment">
        <h3 class="ui medium header">

            <div class="ui grid">

                <div style="direction: rtl" class="column">

                    <a href="aqaed/cp/{{$subject->id}}/{{$subject->level}}" style="color: #00b5ad ; margin-left: 0px" class="ui big right">
                        {{$subject->title}}
                    </a>

                </div>
                <div style="direction: rtl" class="column">

                <a style="color: #00b5ad ; margin-left: 0px" class="ui big left">
                    {{$subject->level}}
                </a>


                </div>
                <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>

                <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>   <div style="direction: rtl" class="column"></div>
                <div style="direction: rtl" class="column">

                    <a style="text-align: center" href="/ar/login" >حذف</a>

                </div>
            </div>

        </h3>

    </div>
    @endforeach

@endsection