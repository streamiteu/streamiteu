//get coordinates
var clickedPointTopic = new ROSLIB.Topic({
    ros : ros,
    name : '/clicked_point'
});

clickedPointTopic.subscribe(function(message) {
   
    document.getElementById('x').value=message.point.x;
    document.getElementById('y').value=message.point.y;
    document.getElementById('z').value=message.point.z;
    window.XVar=message.point.x;
    window.YVar=message.point.y;
    window.ZVar=message.point.z;

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
    points.innerHTML='';
    jsonData.point.forEach(element => {
        points.innerHTML=points.innerHTML+'<button onclick="goToPoint('+element.x+','+element.y+','+element.z+')">'+element.name+'</button>  '
    });

 }