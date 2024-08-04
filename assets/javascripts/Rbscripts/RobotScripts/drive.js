function setDrive(){
    stop=false;
    x=0;
    z=0;
    let interval;
     twist = new ROSLIB.Message({
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
    
     cmdVelTopic = new ROSLIB.Topic({
        ros : ros,
        // name : 'robot/cmd_vel',
        name : '/cmd_vel',
        messageType : 'geometry_msgs/Twist'
    });
    
    
    //This functions are basic cmd_vel_control blocks
     function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }
    
     function moveSomeWhere() {
      
            console.log("Move");
        twist.linear.x = x;
        twist.angular.z = z;
        
        cmdVelTopic.publish(twist);
      
    }

    window.joystickR.on("move", (event, nipple) => {
        var position= nipple.position;
        var distance= nipple.distance;
        var direction = nipple.angle.degree;
        if(direction<10){
            x=0;
            z=0.5;
        }
        else{
     
        if(direction<80){
             x=0.2;
             z=(position.y/position.x)*x;
           
           
           
        }
        else{
            if(direction<110){
                 x=0.2;
                 z=0;
                
               
            }
            else{
                if(direction<170){
                     x=0.2;
                 z=-(position.y/position.x)*x;
              
                }
                else{
                    if(direction<190){
                        x=0;
                        z=-0.5;
                    }
                    else{
                        if(direction<260){
                            x=-0.2;
                            z=-(position.y/position.x)*x;
                        }
                        else{
                            if(direction<280){
                                x=-0.2;
                                z=0;
                            }
                            else{
                                if(direction<350){
                                    x=-0.2;
                                    z=(position.y/position.x)*x;
                                }
                                else{
                                    x=0;
                                    z=0.5;

                                }
                            }
                        }
                    }
                   
                    

                }

            }
        }
        }
       
      });
      window.joystickR.on("start", (event, nipple) => {
        interval=setInterval(()=>{
            moveSomeWhere();
        })
        
      

      });
      window.joystickR.on("end", (event, nipple) => {
        x=0;
        z=0;
        moveSomeWhere();
        clearInterval(interval);

      });
    
    
    // window.addEventListener('keypress', function(event) {
    //     let key=event.keyCode;
        
    //   switch (key)
    //     {
    //         case 119:
    //             moveSomeWhere(1, 0);
    //         break;
    //         case 100:
    //             moveSomeWhere(0, -1);
    //         break;
    //         case 115:
    //             moveSomeWhere(-1, 0);
    //         break;
    //         case 97:
    //             moveSomeWhere(0, 1);
    //         break;
    //         default:
    //         break;
    //     }
    // });
    
    
}

function setDriveRB1(){
    stop=false;
    x=0;
    z=0;
    let interval;
     twist = new ROSLIB.Message({
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
    
     cmdVelTopic = new ROSLIB.Topic({
        ros : ros,
        name : 'robot/cmd_vel',
        messageType : 'geometry_msgs/Twist'
    });
    
    
    //This functions are basic cmd_vel_control blocks
     function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }
    
     function moveSomeWhere() {
      
            console.log("Move");
        twist.linear.x = x;
        twist.angular.z = z;
        
        cmdVelTopic.publish(twist);
      
    }

    window.joystickR.on("move", (event, nipple) => {
        var position= nipple.position;
        var distance= nipple.distance;
        var direction = nipple.angle.degree;
        if(direction<10){
            x=0;
            z=1;
        }
        else{
     
        if(direction<80){
             x=1;
             z=(position.y/position.x)*x;
           
           
           
        }
        else{
            if(direction<110){
                 x=1;
                 z=0;
                
               
            }
            else{
                if(direction<170){
                     x=1;
                 z=-(position.y/position.x)*x;
              
                }
                else{
                    if(direction<190){
                        x=0;
                        z=-1;
                    }
                    else{
                        if(direction<260){
                            x=-1;
                            z=-(position.y/position.x)*x;
                        }
                        else{
                            if(direction<280){
                                x=-1;
                                z=0;
                            }
                            else{
                                if(direction<350){
                                    x=-1;
                                    z=(position.y/position.x)*x;
                                }
                                else{
                                    x=0;
                                    z=1;

                                }
                            }
                        }
                    }
                   
                    

                }

            }
        }
        }
       
      });
      window.joystickR.on("start", (event, nipple) => {
        interval=setInterval(()=>{
            moveSomeWhere();
        })
        
      

      });
      window.joystickR.on("end", (event, nipple) => {
        x=0;
        z=0;
        moveSomeWhere();
        clearInterval(interval);

      });
    
    
    // window.addEventListener('keypress', function(event) {
    //     let key=event.keyCode;
        
    //   switch (key)
    //     {
    //         case 119:
    //             moveSomeWhere(1, 0);
    //         break;
    //         case 100:
    //             moveSomeWhere(0, -1);
    //         break;
    //         case 115:
    //             moveSomeWhere(-1, 0);
    //         break;
    //         case 97:
    //             moveSomeWhere(0, 1);
    //         break;
    //         default:
    //         break;
    //     }
    // });
    
    
}

