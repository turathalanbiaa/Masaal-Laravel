<?php

?>
@foreach($tags as $tag)


    <a style="margin: 5px" href="/fr/tagQuestion/{{$tag->id}}" class="ui label">

        {{$tag->tag}}
    </a>


@endforeach
<div class="ui divider"></div>