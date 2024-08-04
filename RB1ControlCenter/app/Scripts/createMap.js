var nav_viewer = 0;
var nav_client = 0;
function nav_and_map_init() {
   //Create nav2d canvas.           
    nav_viewer = new ROS2D.Viewer({
        divID : 'robot_map',
        width : 500,
        height : 500,
        
    });

            // Setup the nav client.
    nav_client = NAV2D.OccupancyGridClientNav({
        ros : ros,
        continuous: true,
        rootObject : nav_viewer.scene,
        viewer : nav_viewer,
        serverName : '/robot/move_base',
        withOrientation : true,
        topic:'robot/map',

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

// Create the main viewer.


// Setup the nav client.
// var nav;

// var waypointMarker = new ROS2D.NavigationArrow({
//     // https://github.com/RobotWebTools/ros2djs/issues/39

//     // * size(optional) - the size of the marker
//     // * strokeSize(optional) - the size of the outline
//     // * strokeColor(optional) - the createjs color for the stroke
//     // * fillColor(optional) - the createjs color for the fill
//     // * pulse(optional) - if the marker should "pulse" over time

//     size: 0.01,
//     strokeSize: 0.05,
//     fillColor: createjs.Graphics.getRGB(255, 0, 0, 0.66),
//     // pulse: false
//     pulse: true
// });

// function initviewer() {
//     //   ros.connect('ws://{{ domainname }}:9090');
//     console.log('nav_map: init ROS2D.Viewer');
//     viewer = new ROS2D.Viewer({
//         divID: 'nav',
//         width: 500,
//         height: 500
//     });
//     return viewer;
// }
// var viewer=initviewer();

// nav = new NAV2D.ImageMapClientNav({

//     // * ros - the ROSLIB.Ros connection handle
//     // * topic (optional) - the map meta data topic to listen to '/map_metadata'
//     // * image - the URL of the image to render
//     // * serverName (optional) - the action server name to use for navigation, like '/move_base'
//     // * actionName (optional) - the navigation action name, like move_base_msgs/MoveBaseAction'
//     // * rootObject (optional) - the root object to add the click listeners to and render robot markers to
//     // * withOrientation (optional) - if the Navigator should consider the robot orientation (default: false)
//     // * viewer - the main viewer to render to
//     // https://github.com/GT-RAIL/nav2djs/pull/44
//     // https://github.com/GT-RAIL/nav2djs/pull/44/commits/f7a85858e3f2db58392ebda220bd97f17d132a99
//     // var frame_id = options.frame_id || '/map';
//     ros: ros,
//     rootObject: viewer.scene,
//     viewer: viewer,
//     serverName: 'robot/move_base',
//     image: '/static/img/map.png',
//     withOrientation: 'true',
// });
