<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Dashboard - IMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

{{-- Layout ko extend kar rahe hain --}}
@extends('layouts.intern')

{{-- Layout ke @yield('content') wali jagah par yeh data jayega --}}
@section('content')
     <div class="max-w-5xl mx-auto space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-card-gap">
                
                <div class="md:col-span-2 bg-surface-container-lowest rounded-[16px] shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/30 p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2 border-b border-outline-variant/30 pb-3">Daily Action</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6 mt-4">Record your attendance for today. You can only check-in once per day.</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center py-6">
                        @if(!$todayAttendance)
                            <form action="{{ route('attendance.checkin') }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-primary text-on-primary rounded-lg font-label-sm text-label-sm hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">login</span> CHECK IN
                                </button>
                            </form>

                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-surface-container text-on-surface-variant rounded-lg font-label-sm text-label-sm transition-colors shadow-sm flex items-center justify-center gap-2 border border-outline-variant/50 opacity-50 cursor-not-allowed">
                                <span class="material-symbols-outlined">logout</span> CHECK OUT
                            </button>

                        @elseif($todayAttendance && is_null($todayAttendance->check_out))
                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-surface-container text-on-surface-variant rounded-lg font-label-sm text-label-sm opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">login</span> CHECKED IN
                            </button>

                            <form id="autoCheckOutForm" action="{{ route('attendance.checkout') }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-red-600 text-white rounded-lg font-label-sm text-label-sm hover:bg-red-700 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                                    <span class="material-symbols-outlined">logout</span> CHECK OUT
                                </button>
                            </form>

                        @else
                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-surface-container text-on-surface-variant rounded-lg font-label-sm text-label-sm opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">done_all</span> SHIFT COMPLETED
                            </button>

                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-surface-container text-on-surface-variant rounded-lg font-label-sm text-label-sm transition-colors shadow-sm flex items-center justify-center gap-2 border border-outline-variant/50 opacity-50 cursor-not-allowed">
                                <span class="material-symbols-outlined">logout</span> LOCKED
                            </button>
                        @endif
                    </div>
                    
                    <div class="text-center mt-2 space-y-1">
                        <p class="font-label-xs text-label-xs text-outline">Current Date: <span id="liveDate" class="font-medium text-on-surface font-mono">Loading Date...</span></p>
                        <p class="font-label-xs text-label-xs text-outline">Current Time: <span id="liveClock" class="font-medium text-on-surface font-mono">00:00:00 AM</span></p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-[16px] shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/30 p-6 flex flex-col">
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-2 border-b border-outline-variant/30 pb-3">Current Status</h3>
                    <div class="flex-1 flex flex-col items-center justify-center py-8">
                        @if(!$todayAttendance)
                            <div id="statusIconBox" class="w-24 h-24 rounded-full bg-error-container flex items-center justify-center mb-4 transition-colors">
                                <span id="statusIcon" class="material-symbols-outlined text-[40px] text-on-error-container">schedule</span>
                            </div>
                            <span id="statusBadge" class="px-3 py-1 bg-error-container text-on-error-container font-label-xs text-label-xs rounded-full uppercase font-semibold">Not Checked In</span>
                            <p id="statusDesc" class="mt-4 font-body-md text-body-md text-center text-on-surface-variant">You have not checked in for today yet.</p>
                        @elseif($todayAttendance && is_null($todayAttendance->check_out))
                            <div id="statusIconBox" class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mb-4 transition-colors">
                                <span id="statusIcon" class="material-symbols-outlined text-[40px] text-green-700">check_circle</span>
                            </div>
                            <span id="statusBadge" class="px-3 py-1 bg-green-100 text-green-800 font-label-xs text-label-xs rounded-full uppercase font-semibold">Checked In</span>
                            <p id="statusDesc" class="mt-4 font-body-md text-body-md text-center text-on-surface-variant">Your active shift is currently being tracked.</p>
                        @else
                            <div id="statusIconBox" class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-4 transition-colors">
                                <span id="statusIcon" class="material-symbols-outlined text-[40px] text-blue-700">lock_clock</span>
                            </div>
                            <span id="statusBadge" class="px-3 py-1 bg-blue-100 text-blue-800 font-label-xs text-label-xs rounded-full uppercase font-semibold">Shift Completed For Today</span>
                            <p id="statusDesc" class="mt-4 font-body-md text-body-md text-center text-on-surface-variant">Your daily shift is closed. See you tomorrow!</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-[16px] shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/30 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
                    <h3 class="font-headline-md text-headline-md text-on-surface">Daily Attendance History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F1F5F9]">
                                <th class="p-3 font-label-sm text-label-sm text-on-surface-variant font-semibold">Date</th>
                                <th class="p-3 font-label-sm text-label-sm text-on-surface-variant font-semibold">Check-in Time</th>
                                <th class="p-3 font-label-sm text-label-sm text-on-surface-variant font-semibold">Check-out Time</th>
                                <th class="p-3 font-label-sm text-label-sm text-on-surface-variant font-semibold">Total Hours</th>
                                <th class="p-3 font-label-sm text-label-sm text-on-surface-variant font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody" class="font-body-md text-body-md">
                            @forelse($attendances as $att)
                                <tr class="border-b border-outline-variant/20 hover:bg-surface-bright transition-colors h-[52px]">
                                    <td class="p-3 text-primary font-bold">
                                        {{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}
                                    </td>
                                    <td class="p-3 text-on-surface-variant font-mono">
                                        {{ \Carbon\Carbon::parse($att->check_in)->format('h:i A') }}
                                    </td>
                                    <td class="p-3 text-on-surface-variant font-mono">
                                        {{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : '---' }}
                                    </td>
                                    <td class="p-3 text-on-surface-variant font-medium">
                                        {{ $att->hours_worked ? $att->hours_worked . 'h' : 'In Progress...' }}
                                    </td>
                                    <td class="p-3">
                                        @if($att->check_out)
                                            <span class="px-2 py-1 bg-[#E6F4EA] text-[#137333] font-label-xs text-label-xs rounded-full uppercase font-semibold">
                                                {{ $att->performance_percentage }}% Performance
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 font-label-xs text-label-xs rounded-full uppercase font-semibold">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-on-surface-variant">Koi attendance record nahi mila.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection

<script>
    function triggerLiveTimeEngine() {
        const timeNow = new Date();
        
        // 1. Time Calculation (Laptop Format)
        let hours = timeNow.getHours();
        const minutes = timeNow.getMinutes();
        const seconds = timeNow.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        
        let displayHours = hours % 12;
        displayHours = displayHours ? displayHours : 12; 
        
        const clockEl = document.getElementById('liveClock');
        if(clockEl) {
            clockEl.innerText = 
                `${String(displayHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')} ${ampm}`;
        }

        // 2. Date Calculation (Strictly Laptop/Pakistan Date, e.g., Monday, Jun 29, 2026)
        const options = { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' };
        const dateEl = document.getElementById('liveDate');
        if(dateEl) {
            dateEl.innerText = timeNow.toLocaleDateString('en-US', options);
        }

        // 3. AUTOMATIC CHECK-OUT AT 6:00 PM (18:00:00)
        if (hours === 18 && minutes === 0 && seconds === 0) {
            const autoForm = document.getElementById('autoCheckOutForm');
            if (autoForm) {
                autoForm.submit();
            }
        }
    }
    setInterval(triggerLiveTimeEngine, 1000);
    window.onload = triggerLiveTimeEngine;
</script>
</html>