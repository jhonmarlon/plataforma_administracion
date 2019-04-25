
//validacion Login
 $( document ).ready(function() {
    
  $('#envia').click(function(){
      var correo = $('#correo').val();
      var password = $('#password').val();
        console.log(correo);
        console.log(password);
      if(correo != '' && password != ''){
        
       $.ajax({
          url: '../controlador/login.php',
          method: 'POST',
          data: {correo: correo, password: password},
          success: function(msg){
           
           if(msg=='1'){

          $('#mensaje').html('Datos incorrectos');
        }else{

          window.location = msg;
        }
      }

        });
    
      }else{
         $('#mensaje').html('Ingrese los datos');
      }
  });

});






