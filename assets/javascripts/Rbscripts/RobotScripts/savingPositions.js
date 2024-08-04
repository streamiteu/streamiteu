//get coordinates
var clickedPointTopic = new ROSLIB.Topic({
    ros : ros,
    name : '/clicked_point'
});

clickedPointTopic.subscribe(function(message) {
    console.log("x:"+message.point.x);
    console.log("y:"+message.point.y);
    console.log("z:"+message.point.z);

 });

 function positionSave(){
    var posName = document.getElementById('posName').value;
    let xhr = new XMLHttpRequest();
 
    // Making our connection  
    let url = 'http://localhost:3000/insertdata?name='+posName+'&xvar='+window.XVar+'&yvar='+window.YVar+'&zvar='+window.ZVar;
    xhr.open("GET", url, true);

    // function execute after request is successful 
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                listPoint(JSON.parse(this.responseText));
            }	
        }
    // Sending our request 
    xhr.send();

 }

 function getPoints(){
    let xhr = new XMLHttpRequest();
 
    // Making our connection  
    let url = 'http://localhost:3000/data';
    xhr.open("GET", url, true);

    // function execute after request is successful 
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                listPoint(JSON.parse(this.responseText));
            }	
        }
    // Sending our request 
    xhr.send();
 }


 function listPoint(jsonData){
    var points=document.getElementById("points");
    jsonData.point.forEach(element => {
        if(!window.RB1){
        points.innerHTML=points.innerHTML+'<button onclick="goToPoint('+element.x+','+element.y+','+element.z+')">'+element.name+'</button>  '
        }
        else{
            points.innerHTML=points.innerHTML+'<button onclick="goToPointRB1('+element.x+','+element.y+','+element.z+')">'+element.name+'</button>  '
        }
    });

 }