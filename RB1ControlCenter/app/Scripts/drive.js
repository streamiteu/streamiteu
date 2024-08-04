var twist = new ROSLIB.Message({
    linear : {
        x : 0.0,
        y : 0.0,
        z : 0.0
    },
    angular : {
        x : 0.0,
        y : 0.0,
        z : 0.0
    }
});

var cmdVelTopic = new ROSLIB.Topic({
    ros : ros,
    name : 'robot/cmd_vel',
    messageType : 'geometry_msgs/Twist'
});

//This functions are basic cmd_vel_control blocks
function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
}

function moveSomeWhere(linVel, angVel) {
    twist.linear.x = linVel;
    twist.angular.z = angVel;
    
    cmdVelTopic.publish(twist);
}

function goforward() {
    moveSomeWhere(1, 0)
    sleep(100)
    moveSomeWhere(0, 0)
}
function gobackward() {
    moveSomeWhere(-1, 0)
    sleep(100)
    moveSomeWhere(0, 0)
}
function turnright() {
    moveSomeWhere(0, -1)
    sleep(100)
    moveSomeWhere(0, 0)
}
function turnleft() {
    moveSomeWhere(0, 1)
    sleep(100)
    moveSomeWhere(0, 0)
}



window.addEventListener('keypress', function(event) {
    let key=event.keyCode;
    
  switch (key)
    {
        case 119:
            goforward();
        break;
        case 100:
            turnright();
        break;
        case 115:
            gobackward();
        break;
        case 97:
            turnleft();
        break;
        default:
        break;
    }
});

