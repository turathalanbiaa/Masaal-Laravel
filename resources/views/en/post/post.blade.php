<div class="ui green segment">
    <h3 class="ui medium header">
        {{--TODO : PostTitle--}}
        {{$post->title}}
    </h3>
    <p>
        {{--TODO : PostContent--}}
        {{$post->content}}
    </p>
    {{--TODO : PostImage--}}
    @if($post->image !="")
        <img class="ui large image" src="{{\App\Enums\ImagePath::path_post . $post->image}}">
    @endif
</div>
