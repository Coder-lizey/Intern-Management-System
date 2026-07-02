<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation: Check karein ke message empty na ho
        $request->validate([
            'message' => 'required|string',
            'channel' => 'required|string',
        ]);

        // 2. Security Check (Optional lekin behtar hai)
        // Agar aap chahte hain ke sirf General ya Sir Talha ko msg jaye
        if (!in_array($request->channel, ['Global Public Channel', 'Sir Talha'])) {
            return response()->json(['error' => 'Unauthorized channel'], 403);
        }

        // 3. Database mein message save karein
        $message = Message::create([
            'user_id' => Auth::id(), // Jo intern login hai uski ID
            'body'    => $request->message,
            'channel' => $request->channel
        ]);

        // 4. Success Response wapis JavaScript ko bhejein
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data'    => $message
        ]);
    }

    public function fetchMessages($channel)
    {
        // Database se us channel ke messages aur user ka naam nikalein
        $messages = Message::with('user')
            ->where('channel', $channel)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}