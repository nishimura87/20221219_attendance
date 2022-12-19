<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rests(){
        return $this->hasMany(Rest::class);
    }

    public static function getUserRelatedAttendance(){
        $user = Auth::user();
        // 出勤情報を取得する
		$attendance = Attendance::where('user_id', $user->id)->latest()->first();
		return $attendance;
    }
}
