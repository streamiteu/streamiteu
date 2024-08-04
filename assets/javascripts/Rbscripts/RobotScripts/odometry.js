function getCoordinates(){

var odomTopic = new ROSLIB.Topic({
    ros : window.ros,
    name : '/amcl_pose'
    
});
//This lines pull data from subscribed topic odom
odomTopic.subscribe(function(message) {
    var poseX = document.getElementById('poseX');
   
    var x=parseFloat(message.pose.pose.position.x.toFixed(5));
    poseX.innerHTML  = "X = " +  x;
    document.getElementById('poseXH').value=x;
    
    var poseY = document.getElementById('poseY');
    var y= parseFloat(message.pose.pose.position.y.toFixed(5))
    poseY.innerHTML  = "Y = " + y
    document.getElementById('poseYH').value=y;

    var poseZ = document.getElementById('poseZ');
    var z= parseFloat(message.pose.pose.position.z.toFixed(5))
    poseZ.innerHTML  = "Z = " + z
    document.getElementById('poseZH').value=z;
  
    var poseTheta = document.getElementById('orenW');
    poseTheta.innerHTML  = "Orientation W = " + message.pose.pose.orientation.w
    document.getElementById('orenWH').value=message.pose.pose.orientation.w;
    
    var poseLinVel = document.getElementById('orenX');
    poseLinVel.innerHTML  = "Orientation X = " + message.pose.pose.orientation.x
    document.getElementById('orenXH').value=message.pose.pose.orientation.x;
  
    var poseAngVel = document.getElementById('orenZ');
    poseAngVel.innerHTML  = "Orientation Z = " + message.pose.pose.orientation.z
    document.getElementById('orenZH').value=message.pose.pose.orientation.z;

    var poseAngVel = document.getElementById('orenY');
    poseAngVel.innerHTML  = "Orientation Y = " + message.pose.pose.orientation.y
    document.getElementById('orenYH').value=message.pose.pose.orientation.y;
   
    
});
}


function getCoordinatesRB1(){

    var odomTopic = new ROSLIB.Topic({
        ros : window.ros,
        name : '/robot/amcl_pose'
        
    });
    //This lines pull data from subscribed topic odom
    odomTopic.subscribe(function(message) {
        var poseX = document.getElementById('poseX');
       
        var x=parseFloat(message.pose.pose.position.x.toFixed(5));
        poseX.innerHTML  = "X = " +  x;
        document.getElementById('poseXH').value=x;
        
        var poseY = document.getElementById('poseY');
        var y= parseFloat(message.pose.pose.position.y.toFixed(5))
        poseY.innerHTML  = "Y = " + y
        document.getElementById('poseYH').value=y;
    
        var poseZ = document.getElementById('poseZ');
        var z= parseFloat(message.pose.pose.position.z.toFixed(5))
        poseZ.innerHTML  = "Z = " + z
        document.getElementById('poseZH').value=z;
      
        var poseTheta = document.getElementById('orenW');
        poseTheta.innerHTML  = "Orientation W = " + message.pose.pose.orientation.w
        document.getElementById('orenWH').value=message.pose.pose.orientation.w;
        
        var poseLinVel = document.getElementById('orenX');
        poseLinVel.innerHTML  = "Orientation X = " + message.pose.pose.orientation.x
        document.getElementById('orenXH').value=message.pose.pose.orientation.x;
      
        var poseAngVel = document.getElementById('orenZ');
        poseAngVel.innerHTML  = "Orientation Z = " + message.pose.pose.orientation.z
        document.getElementById('orenZH').value=message.pose.pose.orientation.z;
    
        var poseAngVel = document.getElementById('orenY');
        poseAngVel.innerHTML  = "Orientation Y = " + message.pose.pose.orientation.y
        document.getElementById('orenYH').value=message.pose.pose.orientation.y;
       
        
    });
    }


