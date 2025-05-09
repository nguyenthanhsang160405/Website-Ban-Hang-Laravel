<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chat AI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #chat-box {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .message {
            margin-bottom: 15px;
        }

        .user-msg {
            text-align: right;
        }

        .user-msg .msg-content {
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 20px 20px 0 20px;
            max-width: 70%;
        }

        .bot-msg .msg-content {
            background-color: #e9ecef;
            color: #212529;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 20px 20px 20px 0;
            max-width: 70%;
        }
    </style>
</head>
<body>
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Shop Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @include('menu')
            </div>
        </div>
    </nav>

    <!-- Nội dung Chat -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Trò chuyện với AI</h2>
        <div id="chat-box" class="mb-3"></div>
        <div class="input-group">
            <input type="text" id="user-input" class="form-control" placeholder="Nhập tin nhắn..." />
            <button class="btn btn-primary" onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>

    <script>
        function sendMessage() {
            const input = document.getElementById('user-input');
            const message = input.value.trim();
            if (!message) return;

            appendMessage('Bạn', message, 'user-msg');
            input.value = '';

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => {
                appendMessage('AI', data.reply, 'bot-msg');
            });
        }

        function appendMessage(sender, message, type) {
            const chatBox = document.getElementById('chat-box');
            const msgDiv = document.createElement('div');
            msgDiv.className = `message ${type}`;
            msgDiv.innerHTML = `<div class="msg-content">${message}</div>`;
            chatBox.appendChild(msgDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>