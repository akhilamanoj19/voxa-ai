<x-app-layout>
<div class="container-fluid">
    <div class="row g-4">
        <!-- Welcome Card -->
        <div class="col-12">
            <div class="glass-card bg-primary text-white border-0 overflow-hidden position-relative">
                <div class="position-relative z-1">
                    <h1 class="fw-bold mb-2">Welcome back, {{ $user->name }}! 👋</h1>
                    <p class="lead mb-0 opacity-75">Your AI Assistant is ready to help you today.</p>
                </div>
                <i class="fas fa-robot position-absolute end-0 bottom-0 opacity-25 me-4 mb-n3" style="font-size: 8rem;"></i>
            </div>
        </div>

        <!-- Stats -->
        <div class="col-md-4">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fas fa-comments text-primary fs-4"></i>
                    </div>
                    <h5 class="mb-0 fw-semibold">Total Chats</h5>
                </div>
                <h2 class="fw-bold mb-0">{{ $totalChats }}</h2>
                <p class="text-muted small mt-2">Conversations with AI</p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="mb-0 fw-semibold">Chat History</h5>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <tbody>
                            @forelse($recentChats as $chat)
                                <tr onclick="window.location='{{ route('chat.index', $chat->id) }}'" style="cursor: pointer;">
                                    <td style="width: 50px;">
                                        <div class="bg-secondary bg-opacity-10 p-2 rounded text-center">
                                            <i class="fas fa-comment-dots text-secondary small"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-truncate" style="max-width: 400px;">{{ $chat->title }}</div>
                                        <div class="text-muted small">{{ $chat->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ route('chat.delete', $chat->id) }}" method="POST" onsubmit="return confirm('Delete this conversation?')" onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            <i class="fas fa-chevron-right text-muted opacity-50 ms-2"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        No recent chats yet. Start talking to AI!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
