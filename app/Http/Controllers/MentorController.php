<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WeeklySubmission;
use App\Models\Task;

class MentorController extends Controller
{
    // 🎯 1. Intern ki Profile dikhane ke liye
    public function showInternProfile($id)
    {
        $intern = User::findOrFail($id); 

        // Sirf PENDING submissions lana
        $pendingSubmissions = WeeklySubmission::where('user_id', $id)
                                                ->where('status', 'pending')
                                                ->get();

        // Sirf APPROVED submissions lana
        $approvedSubmissions = WeeklySubmission::where('user_id', $id)
                                                 ->where('status', 'approved')
                                                 ->get();

        // Intern ke saare tasks nikalna
        $tasks = Task::where('user_id', $id)->get();

        return view('mentor.profile', compact('intern', 'pendingSubmissions', 'approvedSubmissions', 'tasks'));
    }

    // 🎯 2. Report Review aur Next Week Unlock karne ke liye
    public function reviewTask(Request $request, $id)
    {
        $submission = WeeklySubmission::findOrFail($id);
        
        if ($request->status == 'approved') {
            // Status, rating aur feedback update karein
            $submission->update([
                'status' => 'approved',
                'rating' => $request->rating,
                'feedback' => $request->feedback
            ]);

            $intern = User::find($submission->user_id);
            
            // 🔥 FIX: Check karein agar approved week bara ya barabar hai tabhi next week unlock ho
            if ($intern->unlocked_week <= $submission->week_number) {
                $intern->update([
                    'unlocked_week' => $submission->week_number + 1
                ]);
            }
            
        } else {
            // Agar reject ho to rejected status set karein
            $submission->update([
                'status' => 'rejected',
                'feedback' => $request->feedback
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}