var goToPointzTopic = new ROSLIB.Topic({
    ros : ros,
    name : 'robot/move_base_simple/goal',
    messageType:"geometry_msgs/PoseStamped"
});

 var navCoordinates=new ROSLIB.Message({
 header: {stamp: "now", frame_id: "robot_map"}, 
 pose: {
    position:{x:0,y:0,z:0},
    orientation:{x:0.0,y:0.0,z:0.0,w:0.9}
    }
});

function goToPoint(cX,cY,cZ) {
   console.log("x:"+cX);
              console.log("y:"+cY);
                         console.log("z:"+cZ);
navCoordinates.pose.position.x=parseFloat(cX);
  navCoordinates.pose.position.y=parseFloat(cY);
 navCoordinates.pose.position.z=parseFloat(cZ);
     
goToPointzTopic.publish(navCoordinates);
};


function goTo(){
    var x = document.getElementById('x').value;
    var y = document.getElementById('y').value;
    var z = document.getElementById('z').value;
    goToPoint(x,y,z);

}