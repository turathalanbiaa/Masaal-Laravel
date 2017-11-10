@foreach($question as $one_question)




    <div class="ui green segment">
        <h3 class="ui header">
            <img src="/img/man.jpg">
            <div class="content">
                كرار حساني
                <div class="sub header">2017-10-13 07:30</div>
            </div>


        </h3>

        <p>{{$one_question->content}}</p>
        <div class="ui divider"></div>
        <h3>الجواب :</h3>
        <p>{{$one_question->answer}}</p>


        <div class="ui hidden divider"></div>

        <div class="ui icon">

            <i class="image icon"></i>
            <label>الصورة</label>
            <br>
            <img class="ui large image" src="/img/image.jpg">
        </div>
        <div class="ui hidden divider"></div>

        <div class="ui icon">
            <i class="video icon"></i>
            <label>الفيديو</label>
            <br>

            <iframe  width="100%" height="100%"
                    src="https://www.youtube.com/embed/f9tXknh3ZZs?list=PLKxikzZNxA6F3rvb-vJdoB_5mV03VTiw1"
                    frameborder="0" gesture="media" allowfullscreen></iframe>
        </div>
        <div class="ui hidden divider"></div>

        <div class="ui icon">

            <i class="linkify icon"></i>
            <label>المصدر : </label>
            <a href="https://stackoverflow.com/questions/37790166/how-to-add-youtube-video-as-video-instead-of-an-embedded-iframe">اضفط
                هنا لزيارة المصدر</a>
        </div>
        <div class="ui hidden divider"></div>

        <button class="ui icon button">
            <i class="share icon"></i>
            <label>مشاركة</label>
        </button>

    </div>

@endforeach