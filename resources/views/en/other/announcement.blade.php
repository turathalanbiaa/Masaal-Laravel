
@foreach($announcements as $en_announcement)

    @foreach($en_announcement as $one_announcement )
        <div class="ui green segment">
            <div class="ui grid">
                <div style="direction: ltr" class="column">
                    <div class="ui teal left ribbon label"> Pinned Ad

                    </div>
                    <p style="direction: rtl">{{$one_announcement->content}}</p>
                </div>
            </div>
        </div>
    @endforeach
@endforeach


