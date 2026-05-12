<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            session(['active_conversation_id' => $id]);
        }

        $conversationId = session('active_conversation_id');

        // Verify conversation exists and belongs to user
        if ($conversationId) {
            $exists = Conversation::where('id', $conversationId)->where('user_id', auth()->id())->exists();
            if (!$exists) $conversationId = null;
        }

        if (!$conversationId) {
            $conversation = Conversation::create([
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

        // Create session if it doesn't exist
        if (!$conversationId) {
            $conversation = Conversation::create([
                'user_id' => auth()->id(),
                'title' => Str::limit($userMessage, 40)
            ]);
            $conversationId = $conversation->id;
            session(['active_conversation_id' => $conversationId]);
        } else {
            // Update conversation title if it's still default
            $conversation = Conversation::find($conversationId);
            if ($conversation && $conversation->title === 'New Conversation') {
                $conversation->update(['title' => Str::limit($userMessage, 40)]);
            }
        }
        
        try {
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}", [
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
                $botResponse = "AI Error: The service is temporarily unavailable. Please check your API key.";
            }
        } catch (\Exception $e) {
            $botResponse = "Connection Error: Unable to reach the AI server. Please check your internet.";
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
        session()->forget('active_conversation_id');
        return redirect()->route('chat.index')->with('status', 'Started a new conversation!');
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        Chat::where('conversation_id', $id)->delete();
        $conversation->delete();

        if (session('active_conversation_id') == $id) {
            session()->forget('active_conversation_id');
        }

        return redirect()->route('dashboard')->with('status', 'Conversation deleted successfully!');
    }
}
