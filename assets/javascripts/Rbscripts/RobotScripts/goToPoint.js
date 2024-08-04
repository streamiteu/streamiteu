


  /**
   * Send a goal to the navigation stack with the given pose.
   *
   */
  function sendGoal() {
   
  }


  function cancelGoal() {
    // cancel the current goal
    goal.cancel();
  }

  function goToPoint(pX,pY,pZ,oX,oY,oZ,oW) {
    var actionClient = new ROSLIB.ActionClient({
        ros : ros,
        serverName : '/move_base',
        actionName : 'move_base_msgs/MoveBaseAction'
      });
    
      
      var positionVec3 = new ROSLIB.Vector3(null);
      var orientation = new ROSLIB.Quaternion({x:oX, y:oY, z:oZ, w:oW});
      
      positionVec3.x = pX;
      positionVec3.y = pY;
      positionVec3.z = pZ;
    
      var pose = new ROSLIB.Pose({
        position : positionVec3,
        orientation : orientation
      });
    
      var goal = new ROSLIB.Goal({
            header:{stamp:"now",seq:0,frame_id:""},
          actionClient : actionClient,
          goalMessage : {
            target_pose : {
              header : {
                frame_id : 'map'
              },
              pose : pose
            }
          }
        });
  
        goal.send();
};



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

function goToPointRB1(pX,pY,pZ,oX,oY,oZ,oW) {
  navCoordinates.pose.position.x=parseFloat(pX);
  navCoordinates.pose.position.y=parseFloat(pY);
 navCoordinates.pose.position.z=parseFloat(pZ);
 navCoordinates.pose.orientation.w=parseFloat(oW);
 navCoordinates.pose.orientation.x=parseFloat(oX);
 navCoordinates.pose.orientation.y=parseFloat(oY);
 //navCoordinates.pose.orientation.z=parseFloat(oZ);
   
goToPointzTopic.publish(navCoordinates);
};


function goToRB1(){
  var x = document.getElementById('x').value;
  var y = document.getElementById('y').value;
  var z = document.getElementById('z').value;
  goToPointRB1(x,y,z);

}
