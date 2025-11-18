<x-layouts.admin>
<div class="container-fluid py-4">
    <h3 class="mb-4">Admin Chat Dashboard</h3>

    <div class="row" style="height: 500px;">
        <!-- Users List Sidebar -->
        <div class="col-md-3 border-end overflow-auto" style="height:100%;">
            <h5>Users</h5>
            <ul class="list-group">
                @foreach($users as $userItem)
                    <li class="list-group-item list-group-item-action d-flex align-items-center" 
                        style="cursor:pointer;" 
                        onclick="openChat({{ $userItem->id }}, '{{ $userItem->name }}')">
                        <img src="{{ $userItem->profile_picture ? asset('storage/'.$userItem->profile_picture) : 'https://via.placeholder.com/30' }}" 
                             class="rounded-circle me-2" width="30" height="30">
                        {{ $userItem->name }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Chat Panel -->
        <div class="col-md-9 d-flex flex-column border rounded ps-3" id="chat-panel" style="height:100%; display:none;">
            <h5 id="chat-user-name" class="mt-2 mb-3">Chat</h5>

            <div class="flex-grow-1 overflow-auto p-3 mb-2 bg-light" id="chat-box" style="height:100%; border-radius:8px;">
                <!-- Messages will load here -->
            </div>

            <form id="admin-chat-form" method="POST" style="display:flex;" onsubmit="sendMessage(event)">
                @csrf
                <input type="hidden" name="receiver_id" id="receiver_id">
                <input type="text" name="message" id="admin-message-input" class="form-control me-2" placeholder="Type a message..." required>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
let currentUserId = null;

function openChat(userId, userName) {
    currentUserId = userId;
    document.getElementById('chat-panel').style.display = 'flex';
    document.getElementById('chat-user-name').innerText = 'Chat with ' + userName;
    document.getElementById('receiver_id').value = userId;

    loadMessages();
}

// Load messages via AJAX
function loadMessages() {
    if(!currentUserId) return;

    fetch(`/admin/chat/messages/${currentUserId}`)
        .then(response => response.json())
        .then(data => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            data.forEach(msg => {
                const div = document.createElement('div');
                const isAdmin = msg.sender_id === {{ auth()->id() }};
                div.className = 'd-flex mb-2 ' + (isAdmin ? 'justify-content-end' : 'justify-content-start');
                div.innerHTML = `
                    ${!isAdmin ? `<img src="${msg.sender.profile_picture ? '/storage/' + msg.sender.profile_picture : 'https://via.placeholder.com/30'}" class="rounded-circle me-2" width="30" height="30">` : ''}
                    <div class="p-2 rounded" style="max-width:60%; background-color: ${isAdmin ? '#0d6efd' : '#e5e5ea'}; color: ${isAdmin ? 'white' : 'black'};">
                        ${msg.message}
                        <div class="text-end" style="font-size:0.7rem; color:#555;">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                    </div>
                    ${isAdmin ? `<img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://via.placeholder.com/30' }}" class="rounded-circle ms-2" width="30" height="30">` : ''}
                `;
                chatBox.appendChild(div);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

// Send message via AJAX
function sendMessage(event) {
    event.preventDefault();
    const messageInput = document.getElementById('admin-message-input');
    const receiverId = document.getElementById('receiver_id').value;
    const token = document.querySelector('input[name="_token"]').value;

    fetch('/admin/chat/send', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ message: messageInput.value, receiver_id: receiverId })
    }).then(() => {
        messageInput.value = '';
        loadMessages();
    });
}

// Optional: Auto refresh every 5 seconds
setInterval(() => {
    if(currentUserId) loadMessages();
}, 5000);
</script>
</x-layouts.admin>
