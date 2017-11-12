<table class="ui right aligned unstackable mini table">
    <thead>
    <tr>
        <th>ID</th>
        <th>اسم المسؤول</th>
        <th>الصلاحيات</th>
        <th style="width: 50px !important; text-align: center;">خيارات</th>
    </tr>
    </thead>

    <tbody>
    @if($admins->count() > 0)
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>
                    <a href="/control-panel/{{$lang}}/admin-info-{{$admin->id}}" style="color: rgba(0,0,0,.87);">{{$admin->name}}</a>
                </td>
                <td>{{$admin->manager}}</td>
                <td style="width: 50px !important; text-align: center;">
                    <div class="ui mini vertical buttons">
                        <a href="/control-panel/{{$lang}}/admin-info-{{$admin->id}}" class="ui teal button">عرض</a>
                        <button class="ui red button" data-action="delete-admin" data-id="{{$admin->id}}" data-content="{{$admin->name}}">حذف</button>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">
                <div class="lg-space"></div>
                <div class="lg-space"></div>
                <h1 class="center aligned">لا توجد نتأئج</h1>
                <div class="lg-space"></div>
            </td>
        </tr>
    @endif

    </tbody>
</table>