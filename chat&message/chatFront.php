<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #chat-container {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 600px;
            height: 80vh;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        #chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fafafa;
            border-bottom: 1px solid #ddd;
        }

        #chat-box div {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            max-width: 70%;
        }

        #chat-box .sent {
            background-color: #4caf50;
            color: white;
            align-self: flex-end;
        }

        #chat-box .received {
            background-color: #e0e0e0;
            color: #333;
            align-self: flex-start;
        }

        #message-container {
            display: flex;
            padding: 10px;
            background-color: #f4f4f9;
        }

        #message {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-right: 10px;
            outline: none;
        }

        #message:focus {
            border-color: #4caf50;
        }

        #send {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        #send:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="chat-box"></div>
        <div id="message-container">
            <input type="text" id="message" placeholder="Type your message..." />
            <button id="send">Send</button>
        </div>
    </div>

    <script>
        // 접속한 호스트를 그대로 따라간다. https 페이지면 wss 로 붙어 혼합콘텐츠를 피한다.
        // 운영에서는 .env 의 WS_PATH(예: /ws)로 리버스 프록시 경로를 지정한다.
        // 로컬에서는 WS_PATH 가 비어 있어 예전처럼 :8080 으로 직접 붙는다.
        const wsProtocol = location.protocol === 'https:' ? 'wss://' : 'ws://';
        const wsPath = "<?= getenv('WS_PATH') ?: '' ?>";
        const wsUrl = wsPath
          ? wsProtocol + location.host + wsPath
          : wsProtocol + location.hostname + ':8080';
        const conn = new WebSocket(wsUrl);
        const chatBox = document.getElementById('chat-box');
        const messageInput = document.getElementById('message');
        const sendButton = document.getElementById('send');

        conn.onmessage = (e) => {
            const msg = document.createElement('div');
            msg.className = 'received';
            msg.textContent = e.data;
            chatBox.appendChild(msg);
            chatBox.scrollTop = chatBox.scrollHeight; // 자동 스크롤
        };

        sendButton.addEventListener('click', () => {
            const message = messageInput.value.trim();
            if (message) {
                const msg = document.createElement('div');
                msg.className = 'sent';
                msg.textContent = message;
                chatBox.appendChild(msg);
                conn.send(message);
                messageInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight; // 자동 스크롤
            }
        });
    </script>
</body>
</html>