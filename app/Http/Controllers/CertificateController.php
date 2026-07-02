<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    /**
     * Mentor Side: Page Load Function
     */
    public function index()
    {
        $interns = User::where('role', 'intern')
            ->leftJoin('certificates', 'users.id', '=', 'certificates.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.department',
                'users.avatar',
                DB::raw('COALESCE(certificates.approved_weeks_count, 4) as approved_weeks_count'), 
                DB::raw('COALESCE(certificates.is_unlocked, 0) as is_unlocked')
            )
            ->get();

        return view('mentor.certificate', compact('interns'));
    }

    /**
     * Mentor Side: AJAX Certificate Unlock Function
     */
    public function unlock($intern_id) 
    {
        try {
            $intern = User::findOrFail($intern_id);
            
            DB::table('certificates')->updateOrInsert(
                ['user_id' => $intern_id], 
                [
                    'is_unlocked' => true,
                    'approved_weeks_count' => 4, 
                    'updated_at' => now()
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Certificate successfully unlocked!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🟢 Intern Side: Show Certificate Page (Error Fixer Logic)
     */
    public function showCertificate()
    {
        $userId = auth()->id();
        $certRecord = DB::table('certificates')->where('user_id', $userId)->first();

        // Ek standard object bana rahe hain taake blade file me koi bhi property undefined na ho
        $certificate = new \stdClass();
        $certificate->id = $certRecord->id ?? 0;
        $certificate->is_unlocked = $certRecord->is_unlocked ?? 0;
        $certificate->approved_weeks_count = $certRecord->approved_weeks_count ?? 4;
        
        // TRICK: Agar approved_weeks_count ki value 5 hai, to iska matlab hai ye lock ho chuka hai
        $certificate->is_generated = ($certRecord && $certRecord->approved_weeks_count == 5) ? 1 : 0;
        
        // Database me column na hone ki wajah se direct account ka registered name bhej rahe hain
        $certificate->name_on_certificate = auth()->user()->name;
        $certificate->updated_at = isset($certRecord->updated_at) ? \Carbon\Carbon::parse($certRecord->updated_at) : null;

        return view('intern.certificate', compact('certificate'));
    }

    /**
     * 🟢 Intern Side: Generate & Lock Certificate Action
     */
    public function generateCertificate(Request $request, $id)
    {
        $userId = auth()->id();
        $certRecord = DB::table('certificates')->where('user_id', $userId)->first();
        
        if ($certRecord && $certRecord->approved_weeks_count == 5) {
            return redirect()->back()->with('error', 'Certificate already generated and locked!');
        }

        // approved_weeks_count ko 5 kar rahe hain jo ke is baat ki nishani hai ke ab ye dobara click nahi ho sakta
        DB::table('certificates')->updateOrInsert(
            ['user_id' => $userId],
            [
                'is_unlocked' => 1,
                'approved_weeks_count' => 5, 
                'updated_at' => now()
            ]
        );

        return redirect()->back()->with('success', 'Certificate generated successfully!');
    }
}