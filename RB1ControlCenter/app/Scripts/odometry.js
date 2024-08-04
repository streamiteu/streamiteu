var odomTopic = new ROSLIB.Topic({
    ros : ros,
    name : '/robot/amcl_pose'
    
});
//This lines pull data from subscribed topic odom
odomTopic.subscribe(function(message) {
    var poseX = document.getElementById('poseX');
    var x=parseFloat(message.pose.pose.position.x.toFixed(5));
    poseX.innerHTML  = "X = " +  x;
    //window.XVar=x;
    var poseY = document.getElementById('poseY');
    var y= parseFloat(message.pose.pose.position.y.toFixed(5))
    poseY.innerHTML  = "Y = " + y
    //window.YVar=y;
    var poseZ = document.getElementById('poseZ');
    var z= parseFloat(message.pose.pose.position.z.toFixed(5))
    poseZ.innerHTML  = "Z = " + z
    //window.ZVar=z;
    // var poseTheta = document.getElementById('poseTheta');
    // poseTheta.innerHTML  = "Theta = " + message.pose.pose.orientation.w
    // window.Theta=message.pose.pose.orientation.w;
    // var poseLinVel = document.getElementById('poseLinVel');
    // poseLinVel.innerHTML  = "LinVel = " + message.twist.twist.linear.x
    // window.LinVel=message.twist.twist.linear.x;
    // var poseAngVel = document.getElementById('poseAngVel');
    // poseAngVel.innerHTML  = "AngVel = " + message.twist.twist.angular.z
    // window.AngVel=message.twist.twist.angular.z;
    
});


