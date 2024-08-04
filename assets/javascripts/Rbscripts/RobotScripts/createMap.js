var nav_viewer = 0;
var nav_client = 0;
function nav_and_map_init() {
   //Create nav2d canvas.           
    nav_viewer = new ROS2D.Viewer({
        divID : 'map',
        width : 300,
        height : 300,
        
    });

            // Setup the nav client.
    nav_client = NAV2D.OccupancyGridClientNav({
        ros : window.ros,
        continuous: true,
        rootObject : nav_viewer.scene,
        viewer : nav_viewer,
        // serverName : '/robot/move_base',
        serverName : '/pr2_move_base',
        withOrientation : true,
        // topic:'robot/map',
        topic:'/map',
        // robot_pose:'/robot/robot_pose'
        //robot_pose:'/amcl_pose'

    });
 }

 function nav_and_map_initRB1() {
    //Create nav2d canvas.           
     nav_viewer = new ROS2D.Viewer({
         divID : 'robot_map',
         width : 300,
         height : 300,
         
     });
 
             // Setup the nav client.
     nav_client = NAV2D.OccupancyGridClientNav({
         ros : window.ros,
         continuous: true,
         rootObject : nav_viewer.scene,
         viewer : nav_viewer,
         serverName : '/robot/move_base',
         withOrientation : true,
         topic:'robot/map',
         robot_pose:'/robot/robot_pose'
 
     });
  }


 function MapZoomFunc() {
    nav_viewer.scene.scaleX*=1.25;
    nav_viewer.scene.scaleY*=1.25;
 }      
function MapPanFunc() {
    nav_viewer.scene.scaleX*=0.75;
    nav_viewer.scene.scaleY*=0.75;
}

