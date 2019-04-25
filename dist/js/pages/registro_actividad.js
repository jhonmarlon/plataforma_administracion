/*function validacion(formulario) {
	console.log("validando insert");
			//var x=formulario.area.value;
    	 if ((formulario.tiempoReal.value > 180 || formulario.tiempoReal.value < 5) && formulario.areaa.value != 23 ) {
             alert('El tiempo de las actividades debe estar en el rango de 5 a 180 minutos');
             return false
           }   
}*/


function queryActividad(){
		var id = document.getElementById("id_actividad").value;
        if(id > 0){
	        fetch_actividad(id);
	        fetch_plataforma(id);
	        fetch_categoria(id);
	     }else{
	    	 $('#actividad').val("");
	    	 $('#plataforma').val("");
	    	 $('#categoria').val("");
	     }
}

function fetch_actividad(id){
        var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros,
                url:   'pages/backend/fetch_actividad.php',
                type:  'post',
                beforeSend: function () {
                        console.log("iniciando");
                },
                success:  function (response) {
                    console.log("respuesta: "+response);
                    //document.getElementById("actividad").value = response;
                    $('#actividad').val(response);
                }
        });
}

function fetch_plataforma(id){
        var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros,
                url:   'pages/backend/fetch_plataforma.php',
                type:  'post',
                beforeSend: function () {
                        console.log("iniciando");
                },
                success:  function (response) {
                    console.log("respuesta: "+response);
                    //document.getElementById("actividad").value = response;
                    $('#plataforma').val(response);
                }
        });
}

function fetch_categoria(id){
        var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros,
                url:   'pages/backend/fetch_categoria.php',
                type:  'post',
                beforeSend: function () {
                        console.log("iniciando");
                },
                success:  function (response) {
                    console.log("respuesta: "+response);
                    //document.getElementById("actividad").value = response;
                    $('#categoria').val(response);
                }
        });
}