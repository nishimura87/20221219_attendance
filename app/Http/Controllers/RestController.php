<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function breakin(Request $request)
    {
        $user = Auth::user();

        $breakin = new Carbon();

        $attendances = Attendance::where('user_id', $user->id)->latest()->first();

        //休憩開始時間を登録
        $form['start_time'] =  $breakin;
        $form['attendance_id'] =  $attendances->id;
        unset($form['_token']);

        Rest::create($form);

        return redirect()->back()->with([
                "is_rest_start" => true,
            ]);
    }

    public function breakout(Request $request)
    {
        {
        $breakout = new Carbon();
        $rests = Rest::latest('start_time')->first();

        //休憩終了時間を更新
        $form = $rests->fill([
            'end_time' => $breakout
            ])->save();

        return redirect()->back()->with([
                "is_rest_start" => false
            ]);
        }
    }
}