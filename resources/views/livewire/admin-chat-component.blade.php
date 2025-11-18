<div>
    <div class="row">
    <div class="col-md-3 border-end">
        <ul class="list-group">
            @foreach($users as $user)
                <li class="list-group-item {{ $selectedUser == $user->id ? 'active' : '' }}" wire:click="selectUser({{ $user->id }})" style="cursor:pointer;">
                    <img src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : 'https://via.placeholder.com/40' }}" class="rounded-circle me-2" width="40" height="40">
                    {{ $user->name }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-body" style="height: 400px; overflow-y: auto;" id="chat-box">
                @foreach($messages as $msg)
                    <div class="d-flex mb-2 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-2 rounded {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 70%;">
                            <strong>{{ $msg->sender->name }}</strong><br>
                            {{ $msg->message }}
                            <div class="text-end small">{{ $msg->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 d-flex">
                <input type="text" class="form-control" wire:model="messageText" wire:keydown.enter="sendMessage" placeholder="Type a message">
                <button class="btn btn-primary ms-2" wire:click="sendMessage">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    Livewire.on('messageSent', () => {
        var chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });

    setTimeout(() => {
        var chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }, 100);
</script>

</div>
