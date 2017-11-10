<div class="ui green segment">
    <h3 class="ui medium header">

        {{$post->title}}
    </h3>
    <p> {{$post->content}}</p>
    @if($post->image !="")
        <img class="ui centered large image" src="{{\App\Enums\ImagePath::path_post . $post->image}}">
    @endif

</div>