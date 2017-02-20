@extends('layouts.body')

@section('body')
<!--
<script>
    alert('{{$code}}: {{$msg}}');
    window.location = '{{$url}}';
</script>
        -->

<h4 class="alert-heading" style="color: red;">{{$msg}}</h4>
<p><span id="time">10</span>秒后将自动跳转，现在就<a href="{{$url}}">跳转</a>！</p>

@endsection

@section('js')
    <script language="javascript">
        var t = 10;
        var time = $("#time");
        function fun(){
            t--;
            time.html(t);
            if(t<=0){
                location.href = "{{$url}}";
                clearInterval(inter);
            }
        }
        var inter = setInterval("fun()",1000);
    </script>
@endsection
