<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;


class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $date = new Carbon();
        $date = $date->format('Y-m-d');

		//ログイン中ユーザーの最新データを取得
		$deta = new Attendance;
		$attendance = $deta->getUserRelatedAttendance();

        //ログイン中ユーザーが休憩開始しているか判別
		if(!empty($attendance)){
			$rest = $attendance->rests->whereNull("end_time")->first();
		}

        //データがない場合または本日の出勤がない場合
        if(empty($attendance) || (!empty($attendance) && $attendance['date'] <> $date)){
            return view('index')->with([
                "is_attendance_start" => false,
            ]);
        }

        //退勤している場合
        if(($attendance['date'] == $date) && (!empty($attendance['end_time']))){
            return view('index')->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
                
            ]);
        }

        //出勤している場合
        if($attendance['date'] == $date){
			//休憩開始している場合
            if(!empty($rest)){
                return view('index')->with([
                    "is_attendance_start" => true,
                    "is_attendance_end" => false,
                    "is_rest_start" => true
                ]);
			//休憩開始してない場合
            }else{
                return view('index')->with([
                    "is_attendance_start" => true,
                    "is_attendance_end" => false,
                    "is_rest_start" => false
                ]);
            }
        }
    }

    public function start(Request $request)
    {
        $start = new Carbon();
        $date = date("Y/m/d");

        session()->flash('message', '勤務開始しました');

        //出勤時間を登録
        $form['user_id'] =  Auth::id();
        $form['start_time'] =  $start;
        $form['date'] =  $date;
        unset($form['_token']);

        Attendance::create($form);

        return redirect()->back()->with([
                "is_attendance_start" => true,
                "is_attendance_end" => false,
            ]);
    }

    public function end(Request $request)
    {
        $end = new Carbon();

        session()->flash('message', '勤務終了しました');

        //ログイン中ユーザーの最新データを取得
		$deta = new Attendance;
		$attendance = $deta->getUserRelatedAttendance();

        //退勤時間を更新
        $form = $attendance->fill([
            'end_time' => $end
            ])->save();

        return redirect()->back()->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
            ]);
    }

	public function list(Request $request)
    {
		//閲覧する管理画面の日付表示
		$today = new Carbon();
		$num = $request->num;
		$pre = $num - 1;
		$next = $num + 1;
		$date = $today->modify("+$num day")->format("Y-m-d");

		//表示する日付に紐づくデータ取得
		$attendances = Attendance::where('date',$date)->Paginate(5);

		foreach($attendances as $attendance) {
			$start_time = $attendance->start_time;
			$end_time = $attendance->end_time;

			$work = Attendance::select(DB::raw('timediff(end_time,start_time) as attendancetime'))->where('id', $attendance->id)->value('attendancetime');
			$attendance->attendancetime = $work;

			$results = Rest::selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(end_time,start_time)))) as resttime')->where('attendance_id',$attendance->id)->get();
			foreach($results as $result) {
				$attendance->resttime = $result->resttime;
				$attendance = !empty($result->resttime) ? $result->resttime : 0;
			}
		}

		return view('attendance_list',compact('date','pre','next','attendances'));
    }
}