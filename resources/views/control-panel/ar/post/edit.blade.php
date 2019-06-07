@extends("control-panel.ar.layout.main_layout")

@section("title")
    <title>{{$post->title}}</title>
@endsection

@section("content")
    <div class="ui one column grid">
        <div class="column">
            @include("control-panel.ar.layout.welcome")
        </div>

        <div class="column">
            <div class="ui three item teal big menu" id="special-menu">
                <a class="item" href="/control-panel">
                    <i class="home big icon" style="margin: 0;"></i>&nbsp;
                    <span>الرئيسية</span>
                </a>
                <a class="item active" href="/control-panel/posts">
                    <i class="newspaper big icon" style="margin: 0;"></i>&nbsp;
                    <span>المنشورات</span>
                </a>
                <a class="item" href="/control-panel/posts/create">
                    <i class="add big icon" style="margin: 0;"></i>&nbsp;
                    <span>اضافة منشور</span>
                </a>
            </div>
        </div>

        @if(count($errors))
            <div class="column">
                <div class="ui error message" id="message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session("ArUpdatePostMessage"))
            <div class="column">
                <div class="ui error message">
                    <h2 class="ui center aligned header">{{session("ArUpdatePostMessage")}}</h2>
                </div>
            </div>
        @endif

        <div class="column">
            <div class="ui right aligned segment">
                <h3 class="ui center aligned green dividing header">تحرير المنشور</h3>

                <div class="ui one column grid">
                    <div class="column">
                        <form class="ui form" method="post" action="/control-panel/posts/{{$post->id}}" enctype="multipart/form-data">
                            @csrf()
                            @method("PUT")

                            <div class="field">
                                <label for="title">عنوان المنشور</label>
                                <input type="text" name="title" id="title" value="{{$post->title}}">
                            </div>

                            <div class="field">
                                <label for="content">بعض التفاصيل حول المنشور</label>
                                <textarea rows="5" name="content" id="content">{{$post->content}}</textarea>
                            </div>

                            <div class="inline fields">
                                <div class="ten wide field" style="padding: 0;">
                                    <label for="image">ارفاق صورة</label>
                                    <input type="file" name="image" id="image" placeholder="ارفق صورة مع المنشور اذا كنت ترغب بذلك ... اختياري">
                                </div>

                                <div class="six wide field" id="filed-card">
                                    @if(!is_null($post->image))
                                        <div class="ui fluid card">
                                            <div class="blurring dimmable image">
                                                <div class="ui dimmer">
                                                    <div class="content">
                                                        <div class="center">
                                                            <button class="ui inverted red button" data-action="delete-image">حذف الصورة</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ui fluid bordered image">
                                                    <img src="{{asset("storage/" . $post->image)}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="field" style="text-align: center;">
                                <button type="submit" class="ui green button">حفظ التعديلات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        $('.ui.message').transition({
            animation  : 'flash',
            duration   : '1s'
        });

        //Remove image
        $('.ui.fluid.card .image').dimmer({
            on: 'hover'
        });
        $("button[data-action='delete-image']").click(function () {
            var h3 = "<h3 class='ui center aligned green header'>تم حذف الصورة بنجاح</h3>";
            var input = "<input type='hidden' name='delete' value='1'>";
            var filedCard = $("#filed-card").html(h3 + input);
        });
    </script>
@endsection