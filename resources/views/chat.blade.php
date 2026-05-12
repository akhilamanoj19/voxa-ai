<x-app-layout>
<div class="container-fluid h-100">
    <div class="row h-100 g-0">
        <div class="col-12 d-flex flex-column" style="height: calc(100vh - 120px);">
            <!-- Chat Header -->
            <div class="glass-card mb-3 py-3 px-4 d-flex align-items-center gap-3">
                <div class="position-relative">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-robot text-primary fs-4"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Voxa AI</h5>
                    <small class="text-success fw-medium">Online</small>
                </div>
                <form action="{{ route('chat.clear') }}" method="POST" onsubmit="return confirm('Start a new chat? This will clear history.')">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i> New Chat
                    </button>
                </form>
            </div>

            <!-- Chat Messages Area -->
            <div class="glass-card flex-grow-1 overflow-auto mb-3 p-4" id="chatContainer">
                @foreach($chats->reverse() as $chat)
                    <!-- User Message -->
                    <div class="d-flex justify-content-end mb-4 animate-fade-in">
                        <div class="max-w-75">
                            <div class="bg-primary text-white p-3 rounded-4 shadow-sm mb-1">
                                {{ $chat->user_message }}
                            </div>
                            <div class="text-end small text-muted opacity-75">You • {{ $chat->created_at->format('H:i') }}</div>
                        </div>
                    </div>

                    <!-- Bot Message -->
                    <div class="d-flex justify-content-start mb-4 animate-fade-in">
                        <div class="max-w-75">
                            <div class="bg-light p-3 rounded-4 border shadow-sm mb-1 text-dark bot-message-content">
                                <div class="markdown-body">
                                    {{ $chat->bot_response }}
                                </div>
                            </div>
                            <div class="small text-muted opacity-75">AI Assistant • {{ $chat->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @endforeach

                <!-- Typing Animation (Hidden by default) -->
                <div class="d-flex justify-content-start mb-4 d-none" id="typingIndicator">
                    <div class="bg-light p-3 rounded-4 border shadow-sm">
                        <div class="typing-dots">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input Area -->
            <div class="glass-card p-3">
                <form action="{{ route('chat.send') }}" method="POST" id="chatForm">
                    @csrf
                    <div class="input-group">
                        <button type="button" id="voiceBtn" class="btn btn-light rounded-pill-start px-3" title="Voice Input">
                            <i class="fas fa-microphone text-primary"></i>
                        </button>
                        <input type="text" name="message" id="messageInput" class="form-control border-0 bg-light py-2 text-dark fw-medium" placeholder="Type your message here..." required autocomplete="off">
                        <button type="submit" class="btn btn-primary rounded-pill-end px-4">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .max-w-75 {
        max-width: 75%;
    }
    
    .markdown-body {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .markdown-body p:last-child {
        margin-bottom: 0;
    }
    .markdown-body h1, .markdown-body h2, .markdown-body h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #1a1a1a;
    }
    .markdown-body ul, .markdown-body ol {
        padding-left: 1.25rem;
        margin-bottom: 0.5rem;
    }
    .markdown-body code {
        background: rgba(0,0,0,0.05);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    
    .typing-dots span {
        width: 8px;
        height: 8px;
        background-color: #6366f1;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: typing 1.4s infinite ease-in-out both;
    }

    .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
    .typing-dots span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }

    /* Custom Scrollbar */
    #chatContainer::-webkit-scrollbar {
        width: 6px;
    }
    #chatContainer::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <x-slot name="scripts">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chatContainer');
        const chatForm = document.getElementById('chatForm');
        const typingIndicator = document.getElementById('typingIndicator');

        // Render Markdown
        document.querySelectorAll('.markdown-body').forEach(el => {
            const rawText = el.textContent.trim();
            el.innerHTML = marked.parse(rawText);
        });

        // Scroll to bottom
        chatContainer.scrollTop = chatContainer.scrollHeight;

        chatForm.addEventListener('submit', function() {
            typingIndicator.classList.remove('d-none');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });

        // Voice Recognition Logic
        const voiceBtn = document.getElementById('voiceBtn');
        const messageInput = document.getElementById('messageInput');
        let isListening = false;

        if ('webkitSpeechRecognition' in window) {
            const recognition = new webkitSpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            voiceBtn.addEventListener('click', function() {
                if (isListening) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });

            recognition.onstart = function() {
                isListening = true;
                voiceBtn.innerHTML = '<i class="fas fa-stop-circle text-danger"></i>';
                voiceBtn.title = "Stop Recording";
            };

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                messageInput.value = transcript;
            };

            recognition.onerror = function() {
                isListening = false;
                voiceBtn.innerHTML = '<i class="fas fa-microphone text-primary"></i>';
            };

            recognition.onend = function() {
                isListening = false;
                voiceBtn.innerHTML = '<i class="fas fa-microphone text-primary"></i>';
                voiceBtn.title = "Voice Input";
            };
        } else {
            voiceBtn.style.display = 'none';
        }
    });
</script>
    </x-slot>
</x-app-layout>
