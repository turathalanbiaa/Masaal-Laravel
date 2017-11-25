<table class="ui right aligned unstackable mini table">
    <thead>
    <tr>
        <th>ID</th>
        <th>الاسم</th>
        <th>اسم المستخدم</th>
        <th style="width: 50px !important; text-align: center;">خيارات</th>
    </tr>
    </thead>

    <tbody>
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>
                    <a href="/control-panel/{{$lang}}/admin/info?id={{$admin->id}}" style="color: rgba(0,0,0,.87);">{{$admin->name}}</a>
                </td>
                <td>{{$admin->username}}</td>
                <td style="width: 50px !important; text-align: center;">
                    <div class="ui mini vertical buttons">
                        <a href="/control-panel/{{$lang}}/admin/info?id={{$admin->id}}" class="ui teal button">عرض</a>
                        <button class="ui red button" data-action="delete-admin" data-id="{{$admin->id}}" data-content="{{$admin->name}}">حذف</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>