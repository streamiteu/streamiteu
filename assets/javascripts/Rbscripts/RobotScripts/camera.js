function cam_init() {
    var cam_viewer = new MJPEGCANVAS.Viewer({
        divID : 'mjpeg',
        host : 'localhost',
        width : 500,
        height : 300,
        // topic : '/robot/front_rgbd_camera/rgb/image_raw'
        topic : '/front_rgbd_camera/rgb/image_raw'
    });
}

function cam_initRB1() {
    var cam_viewer = new MJPEGCANVAS.Viewer({
        divID : 'mjpeg',
        host : 'localhost',
        width : 500,
        height : 300,
        topic : '/robot/front_rgbd_camera/rgb/image_raw'
    });
}