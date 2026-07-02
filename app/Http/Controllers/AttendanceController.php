<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * INTERN ATTENDANCE HISTORY VIEW
     */
    public function index()
    {
        // Strictly Pakistan Timezone ke mutabiq aaj ki date check hogi
        $today = Carbon::today('Asia/Karachi')->toDateString();

        $attendances = Attendance::where('user_id', auth()->id())
                        ->orderBy('date', 'desc')
                        ->get();

        $todayAttendance = Attendance::where('user_id', auth()->id())
                            ->where('date', $today)
                            ->first();

        return view('intern.attendance', compact('attendances', 'todayAttendance')); 
    }

    /**
     * CHECK-IN ACTION (Forced Pakistan Time)
     */
    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today('Asia/Karachi')->toDateString();

        $exists = Attendance::where('user_id', $userId)->where('date', $today)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Aap aaj pehle hi check-in kar chuke hain!');
        }

        Attendance::create([
            'user_id' => $userId,
            'date' => $today,
            'check_in' => Carbon::now('Asia/Karachi')->toTimeString(), // Sahi Pakistan Time
            'status' => 'Present'
        ]);

        return redirect()->back()->with('success', 'Check-in kamyab raha!');
    }

    /**
     * CHECK-OUT ACTION (Forced Pakistan Time)
     */
    public function checkOut(Request $request)
    {
        $userId = auth()->id();
        $today = Carbon::today('Asia/Karachi')->toDateString();

        $attendance = Attendance::where('user_id', $userId)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Aapne aaj check-in nahi kiya hua!');
        }

        $checkInTime = Carbon::parse($attendance->check_in);
        $checkOutTime = Carbon::now('Asia/Karachi'); // Sahi Pakistan Time

        // Hours aur performance calculation
        $hoursWorked = round($checkInTime->diffInMinutes($checkOutTime) / 60, 2);
        $performance = $hoursWorked > 0 ? min(round(($hoursWorked / 8) * 100), 100) : 0;

        $attendance->update([
            'check_out' => $checkOutTime->toTimeString(),
            'hours_worked' => $hoursWorked,
            'performance_percentage' => $performance,
        ]);

        return redirect()->back()->with('success', 'Your check-out time has been recorded successfully!');
    }

    /**
     * MENTOR ATTENDANCE VIEW (Sir Talha Ke Liye)
     */
    public function mentorIndex()
    {
        $registeredInterns = User::where('role', 'intern')->get();
        
        $today = Carbon::today('Asia/Karachi')->toDateString();
        $startOfWeek = Carbon::now('Asia/Karachi')->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now('Asia/Karachi')->endOfWeek()->toDateString();
        $startOfMonth = Carbon::now('Asia/Karachi')->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now('Asia/Karachi')->endOfMonth()->toDateString();

        foreach ($registeredInterns as $intern) {
            
            $todayAttendance = Attendance::where('user_id', $intern->id)
                ->where('date', $today)
                ->first();
                
            if ($todayAttendance) {
                if ($todayAttendance->check_out) {
                    $intern->today_status = 'Offline';
                } else {
                    $intern->today_status = ucfirst($todayAttendance->status); 
                }
                $intern->login_time = $todayAttendance->check_in ? Carbon::parse($todayAttendance->check_in)->format('h:i A') : '--:--';
            } else {
                $intern->today_status = 'Absent'; 
                $intern->login_time = '--:--';
            }

            $intern->weekly_present = Attendance::where('user_id', $intern->id)->whereBetween('date', [$startOfWeek, $endOfWeek])->where('status', 'Present')->count();
            $intern->weekly_absent = Attendance::where('user_id', $intern->id)->whereBetween('date', [$startOfWeek, $endOfWeek])->where('status', 'Absent')->count();
            $intern->monthly_present = Attendance::where('user_id', $intern->id)->whereBetween('date', [$startOfMonth, $endOfMonth])->where('status', 'Present')->count();
            $intern->monthly_absent = Attendance::where('user_id', $intern->id)->whereBetween('date', [$startOfMonth, $endOfMonth])->where('status', 'Absent')->count();
        }

        $totalInternsCount = 15; 
        $presentTodayCount = $registeredInterns->whereIn('today_status', ['Present', 'Online'])->count();
        $absentTodayCount = $registeredInterns->where('today_status', 'Absent')->count() + ($totalInternsCount - $registeredInterns->count());
        $notStartedTodayCount = $totalInternsCount - ($presentTodayCount + $absentTodayCount);
        if($notStartedTodayCount < 0) $notStartedTodayCount = 0;

        return view('mentor.attendances', compact(
            'registeredInterns', 'totalInternsCount', 'presentTodayCount', 'absentTodayCount', 'notStartedTodayCount'
        ));
    }
}