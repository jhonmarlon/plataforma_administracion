	
var cronometro;

function empezar(valor) {	
		
		
		contador_m=0;
		num=valor;
		contador_s = $("#segundos"+num).text();
		//contador_mm = $("#minutos"+num).text();		
        contador_m =document.getElementById("endTime"+num).value;
		contador_mm = contador_m;
		h=0;
		
		
			while(contador_mm > 60)
			{
				contador_mm = contador_mm - 60;
				h=h+1;
			}		
		
		if(contador_mm=="") {contador_mm=0;}
		
		
		contador_h = $("#horas"+num).text();
		var user_id = document.getElementById("user_id"+num).value;
		
        s = document.getElementById("segundos"+num);
        m = document.getElementById("minutos"+num);
		
		hh = document.getElementById("horas"+num);
		
		
		
		m.innerHTML = contador_mm;		
		contador_mm=m.innerHTML;
		h="0"+h;
		hh.innerHTML=h;
		if(m.innerHTML<10){m.innerHTML="0"+m.innerHTML;}
		
		
        cronometro = setInterval(

            function(){
				
                if(contador_s==60)

                {
					contador_s="00";                    					
                    contador_m++;
					
					contador_mm++;
					//if(contador_mm<10){contador_mm="0"+contador_mm;}					
					//if(contador_s<10){contador_mm="0"+contador_mm;}
                    m.innerHTML = contador_mm;
					s.innerHTML = contador_s;
					if(m.innerHTML<10){m.innerHTML="0"+m.innerHTML;}
					if(s.innerHTML<10){s.innerHTML="0"+s.innerHTML;}
					
                }
				
				if(contador_mm==60)

				{
					
					contador_mm=0;
					contador_mm="0"+contador_mm;				
					m.innerHTML = contador_mm;
					h++;
					//hh="0"+contador_h;
					hh.innerHTML = h;
				}
								
				if(contador_s<10 && contador_s>0){contador_s="0"+contador_s;}
				
                s.innerHTML = contador_s;
                 contador_m = document.getElementById("endTime"+num).value=contador_m;

                contador_s++;
				
				if(s.innerHTML==59){refresh(user_id, contador_m, num);	}
				 
            } ,1000);
     emp = new Date();	 
	
	 if(contador_mm==0 && contador_s==0)
	 {
		nom=prompt("Introduzca una referencia para la actividad");			
		
                  if(nom != null)
{
if(nom == "")
{
nom="Empty";
nombre = document.getElementById("act"+num);
nombre.innerHTML = nom;
}

else
{
nombre = document.getElementById("act"+num);
nombre.innerHTML = nom;
}
}
else
{
nom="Default"
nombre = document.getElementById("act"+num);
nombre.innerHTML = nom;
}

 
		var datetime = getFormattedDate();	 
		document.getElementById("initDate"+num).value = datetime;
		
		realizaProceso(datetime,user_id, contador_mm, num, nom);
	 }
	 
	 document.getElementById("btn1").disabled = true;
	 document.getElementById("btn2").disabled = true;
	 document.getElementById("btn3").disabled = true;
	 document.getElementById("btn4").disabled = true;
	 document.getElementById("btn5").disabled = true;
	 document.getElementById("btn6").disabled = true;
	 document.getElementById("parar"+num).disabled = false; 
	 document.getElementById("inicio"+num).disabled = true;
	 document.getElementById("guardar"+num).disabled = false;	 
}



function refresh(user, contador_mm, num)
{
	var parametros = {
                
                "user" : user,
				"minutos" : contador_mm,
				"numero" : num,
        };
	
	$.ajax({
                data:  parametros,
                url:   'pages/backend/act_reg.php',
                type:  'post',                
        });
}
	 
function realizaProceso(datetime,user, minutos, num, nom){
        var parametros = {
                "tiempo" : datetime,
                "user" : user,
				"minutos" : minutos,
				"numero" : num,
				"nombre" : nom,
        };
        $.ajax({
                data:  parametros,
                url:   'pages/backend/init_reg.php',
                type:  'post',                
        });
}

function parar(val) { 

	
	num=val;
	clearInterval(cronometro);
	document.getElementById("inicio"+num).disabled = false;
	document.getElementById("guardar"+num).disabled = false;
	document.getElementById("reiniciar"+num).disabled = false;
	document.getElementById("parar"+num).disabled = true;
	
    }		 
	 
	 function getTimeDifference(){
        var _current = new Date();
        var seconds = (_current.getTime() - emp.getTime())/1000;
        seconds = Math.floor(seconds);
    return seconds;
}



function guardar(valor) {   
	//(clearInterval(elcrono);
		num=valor;
		document.getElementById("stopForm"+num).submit();
}

function getFormattedDate() {
	
    var str = emp.getFullYear() + "-" + (emp.getMonth() + 1) + "-" + emp.getDate() + " " +  emp.getHours() + ":" + emp.getMinutes() + ":" + emp.getSeconds();
    return str;
}





//Volver al estado inicial
function reiniciando(val) {
     
    num=val;
    user_id = document.getElementById("user_id"+num).value;
	
	var parametros = {
            "user" : user_id,
			"numero" : num,
    };
        $.ajax({
                data:  parametros,
                url:   'pages/backend/reiniciar.php',
                type:  'post',                
        });
window.setTimeout('location.reload()');
    
}

document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe() {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification('Bitacora de operación', {
      icon: 'http://es.calcuworld.com/wp-content/uploads/sites/2/2015/06/cronometro2.png',
      body: "Hay una tarea en ejecución!!",
    });

    notification.onclick = function () {
      window.open("http://bitacora.compuredes.com.co:8082/vista/actividad.php");      
    };

  }

}

function notifyMeNotWorking() {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification('Bitacora de operación', {
      icon: 'http://www.ubrn.org/wp-content/uploads/2015/01/icon-sleep.png',
      body: "No hay tareas en proceso!!",
    });

    notification.onclick = function () {
      window.open("http://bitacora.compuredes.com.co:8082/vista/actividad.php");      
    };

  }

}
