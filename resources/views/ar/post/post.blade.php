<div>

</div>
<div class="ui green segment">
    <h3 class="ui medium header">
        <div class="ui grid">
            <div style="direction: rtl" class="column">
                <a style="color: #00b5ad ; margin-left: 0px" class="ui big right">
                    {{-$post>title}}
                </a>
            </div>
        </div>
    </h3>
    <p>{{$post->content}}</p>
    @if($post->image !="")
        <img class="ui centered large bordered image" src="{{\App\Enums\ImagePath::path_post . $post->image}}">
    @endif

</div>