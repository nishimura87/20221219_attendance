<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <title>Attendace</title>
  </head>
  <body>
    <div class="atte">
      <header>
        <div class="header_left">
          <h1 class="header_title">Atte</h1>
        </div>
        <div class="header_right">
          <a class="btn1 btn_home" href="/attendance">ホーム</a>
          <a class="btn1 btn_list" href="/attendance/list/0">日付一覧</a>
          <a class="btn1 btn_logout" href="/logout">ログアウト</a>
        </div>
      </header>
      <div class="main">
        <div class="main_top">
        @if (session('message'))
        <div id="FlashMessage">
          <p class="FlashMessage_Text">
            {{session('message')}}
          </p>
        </div>
        @endif
        @if(Auth::check())
          <p class='login_con'>{{ Auth::user()->name }}さんお疲れ様です！</p>
        </div>
        @endif
        <div class="main_con">
          <div class="atte_con">
            @if($is_attendance_start == false)
            <a class="btn2 btn_start1" href="/attendance/start">
              勤務開始
            </a>
            <a class="btn2 btn_end1">
              勤務終了
            </a>
            @endif
          </div>
          <div class="atte_con">
            @if(($is_attendance_start == true) && ($is_attendance_end == false) 
            && ($is_rest_start == true))
            <a class="btn2 btn_start2" href="/attendance/start" >
              勤務開始
            </a>
            <a class="btn2 btn_end1" href="/attendance/end">
              勤務終了
            </a>
          </div>
          <div class="rest_con">
            <a class="btn2 btn_breakin2" href="/rest/breakin">
              休憩開始
            </a>
            <a class="btn2 btn_breakout1" href="/rest/breakout">
              休憩終了
            </a>
            @endif
          </div>
          <div class="atte_con">
            @if(($is_attendance_start == true) && ($is_attendance_end == false) 
            && ($is_rest_start == false))
            <a class="btn2 btn_start2" href="/attendance/start" >
              勤務開始
            </a>
            <a class="btn2 btn_end2" href="/attendance/end">
              勤務終了
            </a>
          </div>
          <div class="rest_con">
            <a class="btn2 btn_breakin1" href="/rest/breakin">
              休憩開始
            </a>
            <a class="btn2 btn_breakout2" href="/rest/breakout">
              休憩終了
            </a>
            @endif
          </div>
          <div class="atte_con">
            @if(($is_attendance_start == true) && ($is_attendance_end == true))
            <a class="btn2 btn_start2" href="/attendance/start">
              勤務開始
            </a>
            <a class="btn2 btn_end1" href="/attendance/end">
              勤務終了
            </a>
            @endif
          </div>
        </div>
      </div>
      <footer>
        <a class="fotter_text">Atte,inc.</a>
      </footer>
    </div>
  </body>
</html>
<script>
  if( "{{session('message')}}" ){
    const messageIdValue = "{{ uniqid() }}";
    if (sessionStorage) {
      if (sessionStorage.getItem('messageId') === messageIdValue) {
        document.getElementById('FlashMessage').style.display = "none";
      }else{
        sessionStorage.setItem('messageId', messageIdValue);
      }
    }    
  }
</script>
<!-- <script src="{{ asset('/js/hoge.js') }}"></script> -->