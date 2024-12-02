@vite('resources/js/app.js')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
        }

        .chat-message {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .chat-message.sender {
            text-align: right;
            background-color: #e9ecef;
            border-radius: 15px 15px 0 15px;
            margin-bottom: 10px;
        }

        .chat-message.receiver {
            text-align: left;
            background-color: #f8f9fa;
            border-radius: 15px 15px 15px 0;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chat - Welcome, {{ $username }}!</div>
                    <div class="card-body chat-box" id="message">
                        <!-- Static Chat Messages -->

                        {{-- reciever  --}}


                    </div>
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Type your message here..."
                        id="messageInput">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="sendMsg()">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function sendMsg() {
        sender = "{{ $username }}"
        csrfToken = "{{ csrf_token() }}"
        message = messageInput.value
        $.ajax({
            type: 'POST',
            url: "{{ route('send-msg') }}",
            data: {
                sender: sender,
                message: message,
                _token: csrfToken,
            },
            success: function(response) {
                $("#message").append(`
                   <div class="chat-message sender w-50 ml-auto">
                            <strong>You:</strong> ${response.message}
                    </div>
                `)
            },
            error: function(response) {
                console.log(data)
            }
        });
    }

    window.onload = () => {
        window.Echo.channel('user-message').listen('MessageSentEvent', function(data) {
            if (data.sender != "{{ $username }}") {
                $("#message").append(`
                             <div class="chat-message receiver w-50">
                                    <strong>${data.sender}:</strong> ${data.message}
                                </div>
                        `)
            }
        })
    }
</script>

</html>
