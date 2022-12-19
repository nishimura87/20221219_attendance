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
      <div class="calendar">
        <a class="change_date" href="/attendance/list/{{ $next }}"><</a>
        <a class="date">{{$date}}</a>
        <a class="change_date" href="/attendance/list/{{ $pre }}">></a>
      </div>
      <table calss = "table table-attendance">
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        @foreach ($attendances as $attendance)
        <tr>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ date('H:i:s',strtotime($attendance->start_time)) }}</td>
          <td>{{ date('H:i:s',strtotime($attendance->end_time)) }}</td>
          <td>
            @if(!empty($attendance->resttime))
            {{ $attendance->resttime }}
            @else
            {{ date('H:i:s',strtotime('000000')) }}
            @endif
          </td>
          <td>{{ $attendance->attendancetime }}</td>
        </tr>
        @endforeach 
      </table>
      {{ $attendances->links() }}
    </div>
    <footer>
      <a class="fotter_text">Atte,inc.</a>
    </footer>
  </div>
</body>
</html>