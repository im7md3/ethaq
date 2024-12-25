<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Voice Call</title>
    <script src="https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.3.1.js"></script>
</head>

<body>
    <div id="video"></div>

    <script>
        // Initialize the Agora SDK
        var agora = AgoraRTC.createClient({
            mode: 'rtc',
            codec: 'vp8'
        });
        agora.init('48aec0e7ccdd47faa390f4d4cd25d47b', function() {
            // Create a local stream
            var localStream = AgoraRTC.createStream({
                streamID: '3',
                audio: true,
                video: false,
            });
            localStream.init(function() {
                // Play the local stream
                localStream.play('video');

                // Join the channel
                agora.join(null, 'amraa', null, function(uid) {
                    // Create a remote stream for each user in the channel
                    agora.on('stream-added', function(event) {
                        var remoteStream = event.stream;
                        agora.subscribe(remoteStream, function() {
                            // Play the remote stream
                            remoteStream.play('video');
                        });
                    });

                    // Play the remote stream for the current user
                    agora.on('stream-subscribed', function(event) {
                        var remoteStream = event.stream;
                        remoteStream.play('video');
                    });
                });
            });
        });
    </script>
</body>

</html>

