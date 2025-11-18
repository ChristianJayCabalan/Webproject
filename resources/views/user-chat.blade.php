<x-layouts.app>
    <link rel="stylesheet" href="{{ asset('css/user-chat.css') }}"> 
<div class="container py-5">
    <h3 class="mb-4 chat-header header-animate">
    <i class="fa-solid fa-comments me-2"></i> Chat with Admin
    <span class="line"></span> <!-- decorative line -->
</h3>


    <!-- Chatbox -->
    <div class="border rounded p-3 mb-3 bg-white" style="height:400px; overflow-y:scroll;" id="chat-box">
        @foreach($messages as $msg)
            <div class="d-flex mb-3 {{ $msg->sender_id == $user->id ? 'justify-content-end' : 'justify-content-start' }}">
                
                @if($msg->sender_id != $user->id)
                    <!-- Admin profile picture -->
                    <img src="{{ $admin->profile_picture ? asset('storage/' . $admin->profile_picture) : asset('images/default-avatar.png') }}" 
                         class="rounded-circle me-2" style="width:60px; height:60px; object-fit:cover;" alt="Admin">
                @endif

                <!-- Message Bubble -->
                <div style="max-width:70%;">
                    @if($msg->sender_id != $user->id)
                        <small class="text-muted d-block mb-1">Admin:</small>
                    @else
                        <small class="text-muted d-block mb-1">You:</small>
                    @endif
                    <div class="p-3 rounded {{ $msg->sender_id == $user->id ? 'bg-primary text-white' : 'bg-light border' }}" style="word-wrap:break-word; font-size:1.70rem;">
                        {{ $msg->message }}
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size:1.25rem;">
                        {{ $msg->created_at->format('H:i') }}
                    </small>
                </div>

                @if($msg->sender_id == $user->id)
                    <!-- User profile picture -->
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.png') }}" 
                         class="rounded-circle ms-2" style="width:60px; height:60px; object-fit:cover;" alt="You">
                @endif

            </div>
        @endforeach
    </div>

    <!-- Message Form -->
    <form action="{{ route('user.chat.send') }}" method="POST" class="d-flex">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $admin->id }}">
        <input type="text" name="message" class="form-control me-2" placeholder="Type a message..." required>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>

<!-- Auto-scroll -->
<script>
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
</x-layouts.app>
