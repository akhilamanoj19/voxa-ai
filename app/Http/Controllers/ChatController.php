<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chat;

class ChatController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            session(['active_conversation_id' => $id]);
        }

        $conversationId = session('active_conversation_id');

        if (!$conversationId) {
            $conversation = \App\Models\Conversation::create([
                'user_id' => auth()->id(),
                'title' => 'New Conversation'
            ]);
            $conversationId = $conversation->id;
            session(['active_conversation_id' => $conversationId]);
        }

        $chats = Chat::where('conversation_id', $conversationId)->orderBy('created_at', 'desc')->get();
        return view('chat', compact('chats'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $apiKey = config('services.gemini.key');
        $conversationId = session('active_conversation_id');

        // Update conversation title if it's still default
        $conversation = \App\Models\Conversation::find($conversationId);
        if ($conversation && $conversation->title === 'New Conversation') {
            $conversation->update(['title' => \Illuminate\Support\Str::limit($userMessage, 40)]);
        }
        
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $botResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? "I'm sorry, I couldn't process that.";
            } else {
                $botResponse = "API Error: " . ($response->json()['error']['message'] ?? 'Unknown error');
            }
        } catch (\Exception $e) {
            $botResponse = "Connection Error: " . $e->getMessage();
        }

        Chat::create([
            'user_id' => auth()->id(),
            'conversation_id' => $conversationId,
            'user_message' => $userMessage,
            'bot_response' => $botResponse,
        ]);

        return redirect()->back();
    }

    public function clearChat()
    {
        // Instead of deleting, just start a new session
        session()->forget('active_conversation_id');
        return redirect()->back()->with('status', 'Started a new conversation!');
    }
}
