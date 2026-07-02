<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\WeeklySubmission;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * 1. Main Page Load Karne Ke Liye
     */
    public function index()
    {
        $currentWeek = auth()->user()->unlocked_week ?? 1;

        $tasks = Task::where('user_id', auth()->id())
                     ->where('week_number', $currentWeek)
                     ->get();

        $weeklySubmissions = WeeklySubmission::where('user_id', auth()->id())->get();

        return view('intern.task', compact('tasks', 'weeklySubmissions'));
    }

    /**
     * 2. Naya Task Database me Save karne ke liye
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'assigned_date' => 'required|date',
            'deadline' => 'required|date',
            'type' => 'required',
            'week_number' => 'required|integer',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'week_number' => $request->week_number,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'assigned_date' => $request->assigned_date,
            'deadline' => $request->deadline,
            'git_link' => $request->git_link,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Task successfully created!');
    }

    /**
     * 3. Task ko Edit/Update karne ke liye
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'deadline' => 'required|date',
            'type' => 'required',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'deadline' => $request->deadline,
            'git_link' => $request->git_link,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    /**
     * 4. Task Delete karne ke liye
     */
    public function destroy($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    /**
     * 5. Checkbox status toggle (Pending <-> Completed)
     */
    public function toggle($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->status = ($task->status === 'Completed') ? 'Pending' : 'Completed';
        $task->save();

        return redirect()->back()->with('success', 'Task status updated!');
    }

    /**
     * 6. Individual Task ka Git link submit karne ke liye
     */
    public function submitLink(Request $request, $id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->git_link = $request->git_link;
        $task->status = 'Completed';
        $task->save();

        return redirect()->back()->with('success', 'Task link submitted successfully!');
    }

    /**
     * 7. Final Weekly PDF Report Submit karne ke liye
     */
    public function storeSubmission(Request $request)
    {
        $request->validate([
            'report_file' => 'required|mimes:pdf,doc,docx|max:5120',
            'git_link' => 'required|url',
            'week_number' => 'required|integer',
        ]);

        $filePath = $request->file('report_file')->store('reports', 'public');

        WeeklySubmission::create([
            'user_id' => auth()->id(),
            'week_number' => $request->week_number,
            'git_link' => $request->git_link,
            'report_file' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Weekly report submitted to Sir Talha successfully!');
    }

    public function showInternProfile($id)
    {
        $intern = \App\Models\User::findOrFail($id);
        $pendingSubmissions = \App\Models\WeeklySubmission::where('user_id', $id)->where('status', 'pending')->get();
        $approvedSubmissions = \App\Models\WeeklySubmission::where('user_id', $id)->where('status', 'approved')->get();

        return view('mentor.profile', compact('intern', 'pendingSubmissions', 'approvedSubmissions'));
    }

    public function reviewTask(Request $request, $id)
    {
        $submission = \App\Models\WeeklySubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->feedback = $request->feedback;
        $submission->rating = $request->rating;
        $submission->save();

        if ($request->status == 'approved') {
            $user = \App\Models\User::find($submission->user_id);
            $user->unlocked_week = $submission->week_number + 1;
            $user->save();
        }

        return back()->with('success', 'Task reviewed successfully!');
    }
}