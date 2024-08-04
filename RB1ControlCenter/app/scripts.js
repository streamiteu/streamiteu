var ros = new ROSLIB.Ros({
    url : 'ws://localhost:9090'
});

// This function is called upon the rosbridge connection event
ros.on('connection', function() {
    // Write appropriate message to #feedback div when successfully connected to rosbridge
    var fbDiv = document.getElementById('feedback');
    fbDiv.innerHTML = "<p>Connected to Robot Operation System Server</p>";
});

// This function is called when there is an error attempting to connect to rosbridge
ros.on('error', function(error) {
    // Write appropriate message to #feedback div upon error when attempting to connect to rosbridge
    var fbDiv = document.getElementById('feedback');
    fbDiv.innerHTML = "<p>Error connecting to websocket server</p>";
});

// This function is called when the connection to rosbridge is closed
ros.on('close', function() {
    // Write appropriate message to #feedback div upon closing connection to rosbridge
    var fbDiv = document.getElementById('feedback');
    fbDiv.innerHTML = "<p>Connection to websocket server closed</p>";
});


