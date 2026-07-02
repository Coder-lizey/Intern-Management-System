<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Chat - IMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@extends('layouts.intern')

@section('content')
<div class="flex-1 flex bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden mb-2 relative h-[600px]">
    
    <!-- Sidebar -->
    <div id="collapsible-directory-sidebar" class="w-[280px] h-full bg-slate-50 border-r border-slate-200 flex flex-col flex-shrink-0 transition-all duration-300">
        <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-100">
            <span class="text-xs font-bold uppercase text-slate-500">Workspace</span>
            <button onclick="executeSidebarVisibilityToggle()" class="text-slate-500 text-xs">Close</button>
        </div>
        
        <!-- Group Channel -->
        <div class="p-3 border-b border-slate-200">
            <button onclick="switchChannel('Global Public Channel')" class="w-full text-left px-3 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold text-xs transition hover:bg-blue-200"># general-discussion</button>
        </div>

        <!-- Mentor Direct Chat -->
        <div class="flex-1 p-3">
            <span class="text-[10px] font-bold uppercase text-slate-400 px-2 block mb-2">My Mentor</span>
            <div onclick="switchChannel('Mentor')" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-slate-200 cursor-pointer transition">
                <div class="w-8 h-8 rounded-full bg-amber-600 text-white flex items-center justify-center text-xs font-bold">ST</div>
                <div class="text-xs font-bold text-slate-700">Sir Talha</div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 h-full flex flex-col bg-white relative">
        
        <!-- Top Header with Announcement -->
        <div class="flex flex-col">
            <!-- Header -->
            <div class="h-12 px-6 bg-white border-b flex items-center">
                <button onclick="executeSidebarVisibilityToggle()" class="mr-3 text-slate-500 font-bold">☰</button>
                <h4 id="header-context-title" class="text-sm font-bold text-slate-800">Global Public Channel</h4>
            </div>
            
            <!-- Announcement Banner (Read Only for Intern) -->
            <div class="bg-amber-50 border-b border-amber-200 px-6 py-2 flex items-start gap-2">
                <span class="text-amber-600 mt-0.5">📢</span>
                <div>
                    <span class="text-xs font-bold text-amber-800 block">Latest Announcement</span>
                    {{-- Is variable ko backend se pass karein --}}
                    <span class="text-xs text-amber-700">{{ $announcement ?? 'Welcome to the Verge Systems Internship Program. Please complete your daily tasks.' }}</span>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages-scroller-canvas" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50">
            <div id="dynamic-log-injection-terminal"></div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t">
            <div class="max-w-4xl mx-auto bg-slate-50 rounded-xl border border-slate-200 p-2 relative">
                <textarea id="live-chat-input-node" rows="2" class="w-full bg-transparent border-0 resize-none text-sm px-3 focus:ring-0 outline-none" placeholder="Type your message..."></textarea>
                
                <div class="flex items-center justify-between border-t border-slate-200 pt-2 mt-1">
                    <div class="flex gap-2 text-xl">
                        <button onclick="addEmoji('👍')" class="hover:bg-slate-200 px-2 rounded">👍</button>
                        <button onclick="addEmoji('✅')" class="hover:bg-slate-200 px-2 rounded">✅</button>
                        <button onclick="addEmoji('🙌')" class="hover:bg-slate-200 px-2 rounded">🙌</button>
                    </div>
                    <button onclick="sendAjaxMessage()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-1.5 rounded-lg text-xs font-bold transition">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Apni purani JS script yahan rakh lein -->
<script>
    let currentChannel = 'Global Public Channel';
    
    // PHP se Login User ki ID aur Naam JS mein laa rahe hain
    const myUserId = {{ auth()->id() }};
    const myUserName = "{{ auth()->user()->name }}";

    // Jab page pehli baar load ho toh General chat load ho jaye
    window.onload = () => {
        switchChannel(currentChannel);
    };

    // 1. Channel Switch aur Messages Load Karne Ka Logic
    async function switchChannel(name) {
        currentChannel = name;
        document.getElementById('header-context-title').innerText = name;
        const terminal = document.getElementById('dynamic-log-injection-terminal');
        
        terminal.innerHTML = '<div class="text-center text-xs text-outline my-4">Messages load ho rahe hain...</div>'; 

        // Database se is channel ke messages mangwayein
        const response = await fetch(`/get-messages/${encodeURIComponent(currentChannel)}`);
        const messages = await response.json();
        
        terminal.innerHTML = ''; // Loading text hata den

        // Har message ko screen par draw karein
        messages.forEach(msg => {
            appendMessageToScreen(msg.body, msg.user.name, msg.user_id);
        });

        scrollToBottom();
    }

    // 2. Naya Message Send Karne Ka Logic
    async function sendAjaxMessage() {
        const input = document.getElementById('live-chat-input-node');
        const message = input.value.trim();
        if (!message) return;

        const response = await fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: message, channel: currentChannel })
        });

        if (response.ok) {
            // Agar send ho gaya toh foran screen par show kar do
            appendMessageToScreen(message, myUserName, myUserId);
            input.value = '';
        }
    }

    // 3. Screen Par Message Draw Karne Ka Helper Function
    function appendMessageToScreen(text, senderName, senderId) {
        const terminal = document.getElementById('dynamic-log-injection-terminal');
        const isMe = (senderId === myUserId); // Pata lagayein ke kya ye mera message hai
        
        // Naam se initials nikalein (e.g., Zain Ahmed -> ZA)
        const initials = senderName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

        if (isMe) {
            // Mera Message (Right Side - Blue)
            terminal.innerHTML += `
                <div class="flex items-start gap-3 max-w-xl ml-auto flex-row-reverse mb-4">
                    <div class="w-7 h-7 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-xs font-bold flex-shrink-0">${initials}</div>
                    <div class="text-right">
                        <div class="flex items-baseline gap-1.5 mb-0.5 justify-end flex-row-reverse">
                            <span class="text-xs font-bold text-on-surface">${senderName} (Me)</span>
                        </div>
                        <div class="bg-primary text-white p-3 rounded-l-xl rounded-br-xl text-xs text-left shadow-xs">
                            ${text}
                        </div>
                    </div>
                </div>`;
        } else {
            // Dusray ka Message (Left Side - Grey)
            terminal.innerHTML += `
                <div class="flex items-start gap-3 max-w-xl mb-4">
                    <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold flex-shrink-0">${initials}</div>
                    <div>
                        <div class="flex items-baseline gap-1.5 mb-0.5">
                            <span class="text-xs font-bold text-on-surface">${senderName}</span>
                        </div>
                        <div class="bg-white border border-outline-variant/20 p-3 rounded-r-xl rounded-bl-xl text-xs text-on-surface shadow-xs">
                            ${text}
                        </div>
                    </div>
                </div>`;
        }
        scrollToBottom();
    }

    // Auto Scroll niche karne ke liye
    function scrollToBottom() {
        const scroller = document.getElementById('messages-scroller-canvas');
        scroller.scrollTop = scroller.scrollHeight;
    }

    // Sidebar aur Utilities
    function executeSidebarVisibilityToggle() { document.getElementById('collapsible-directory-sidebar').classList.toggle('hidden'); }
    function addEmoji(e) { document.getElementById('live-chat-input-node').value += e; }
    function appendMention(m) { 
        document.getElementById('live-chat-input-node').value += m + ' ';
        document.getElementById('mention-selection-overlay').classList.add('hidden');
    }
</script>

</html>