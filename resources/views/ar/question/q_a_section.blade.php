<div class="ui label">
    أ
</div>
<br>
<br>


@foreach($tags as $tag)

    <div class="ui tag labels">
        <a href="/ar/tagQuestion/{{$tag->id}}" class="ui label">
            {{$tag->tag}}
        </a>

    </div>
@endforeach
<div class="ui divider"></div>