<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>学生综合满意度调查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width,  initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="renderer" content="webkit"/>
    <link rel="stylesheet" href="{{ URL::asset('/static/home/css/word.css') }}">
</head>
<body>
<main>
    <div class="describe">
        <h1>学生综合满意度调查</h1>
    </div>
    <form action="{{ route('word_store') }}" class="" method="post">
        {{ csrf_field() }}
        <div class="single-election">
            <h3 style="text-align: center;">班级：{{ $info['className'] }}&emsp;老师：{{ $info['teacherName'] }}</h3>
            <div id="select">
                @foreach($topics as $value)
                    <div class="question-describe">{{ $value->name }}</div>
                    <div class="question-answer">
                        <label><input type="radio" name="{{ $value->id }}" value="5"/><span>非常符合</span></label>
                        <label><input type="radio" name="{{ $value->id }}" value="4"/><span>符&emsp;&emsp;合</span></label>
                        <label><input type="radio" name="{{ $value->id }}" value="3"/><span>差&nbsp;不&nbsp;多</span></label>
                        <label><input type="radio" name="{{ $value->id }}" value="2"/><span>不咋符合</span></label>
                        <label><input type="radio" name="{{ $value->id }}" value="1"/><span>很不符合</span></label>
                    </div>
                @endforeach
                <div class="text-input">
                    <p>其他意见:</p>
                    <textarea name="comment" class="text" id="text"  placeholder="其他的建议" maxlength="300"></textarea>
                </div>
            </div>
        </div>
        <div class="submit">
            <button type="submit">提交</button>
        </div>
    </form>
</main>
<section class="complete">
    <h1>：》</h1>
    <p>提交成功</p>
</section>
<script>

 // function electionSelect(e) {
 //    if(e.target.nodeName!=='INPUT')return;
 //    var node = e.target.parentNode.parentNode.parentNode;
 //    node.setAttribute('aria-selected',true);
 //    node.setAttribute('selected',true);
 //    node.classList.remove('warning')
 //  }
 //  document.querySelector('.single-election').addEventListener('click',electionSelect);
 //  var from = document.forms[0];
 //  from.addEventListener('submit', function (e) {
 //    e.preventDefault();
 //    var target = e.target;
 //    var singleElection = target.querySelectorAll('.question');
 //    if(singleElection){
 //      for (var i=0;i<singleElection.length;i++){
 //        if(singleElection[i].getAttribute('selected')!=='true'){
 //          singleElection[i].classList.add('warning');
 //          alert('请填写完整');
 //          return;
 //        }
 //      }
 //    }
 //    var text = document.querySelector('.text');
 //    if(text.value.length<5){
 //      return false;
 //    }
 //    var data = new FormData(target);
 //    var xhr = new XMLHttpRequest();
 //    xhr.onreadystatechange=function (ev) {
 //      if(xhr.readyState === 4){
 //        var status = xhr.status;
 //        if(status >= 200 && status <300 ){
 //          console.log('发送成功',xhr.response);
 //            location.href="{:url('yes/index')}";
 //        }else {
 //          console.log('发送失败');
 //        }
 //      }
 //    };
 //    // 地址
 //    xhr.open('POST',this.action,true);
 //    xhr.send(data);
 //  })

</script>
</body>
</html>