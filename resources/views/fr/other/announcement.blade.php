@foreach($announcements as $ar_announcement)

    @foreach($ar_announcement as $one_announcement )
        <div class="ui green segment">
            <div class="ui grid">
                <div style="direction: ltr" class="column">
                    <div class="ui teal left ribbon label">Annonce installée
                    </div>
                    <p style="direction: rtl">{{$one_announcement->content}}</p>
                </div>
            </div>
        </div>
    @endforeach
@endforeach


