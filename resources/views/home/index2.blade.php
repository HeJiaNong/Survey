<form>

    <select name="type">
        @foreach($word as $value)
            <option value ="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>

    <br>

    <select name="class" class="class_selected">
        @foreach($grade as $value)
            <option value ="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>

    <br>

    <select name="teacher" class="teacher_name">
        <option value ="0">请选择</option>
        @foreach($grade as $value)
            <option value ="{{ $value->teacher->id }}">{{ $value->teacher->name }}</option>
        @endforeach
    </select>
</form>

<script>
    /*用于班级异步上传返回老师的值*/
    $(".class_selected").change(function(){
        var id = $(".class_selected").val();
        var per = $(".per").val();
        var url = '{{ route('home') }}'+'/teacher/'+id;
        // $(".teacher_name").text("数据请求中，请稍后...");
        // $.post('/index/index/teacher_local_select.html',{id:id,per_id:per},function (data,status) {
        //     $('.teacher_name').empty();
        //     $.each(data, function(key, val) {
        //         $('.teacher_name').append('<option value="'+val.id+'">'+val.name+'</option>');
        //     });
        // });

        console.log(url);
        $.ajax({
            async: true,    //异步
            type: "GET",
            url: url,
            traditional: true,
            // data:id,
            dataType: "json",
            cache: true,
            //服务器返回执行操作的状态
            success: function(data) {
                $('.teacher_name').empty();
                $.each(data, function(key, val) {
                    $('.teacher_name').append('<option value="'+key+'">'+val+'</option>');
                });
            },
            error:function (data) {
                console.log('操作失败!');
            }
        });


    });
</script>