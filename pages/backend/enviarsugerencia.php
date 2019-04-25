<?php 
session_start ();
if ($_SESSION ['authenticated'] == 1) {
$correo  =$_POST['correo'];
$nombre  =$_POST['nombre'];
$mensaje  =$_POST['mensaje'];
$encabezado  =$_POST['encabezado'];      
 
        
$asunto = "'.$encabezado.'"; 
$cuerpo = ' 
<head> 
<base target="_blank"> 
</head> 
<body bgcolor="ffffff" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="000033"> 
<tr> 
<td align="center"> <b><font face="verdana,arial,helvetica" size="4" color=ffffff> SUGERENCIA</font></b></td> 
</tr> 
<tr> 
</table> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="cccc66"> 
<tr> 
<td bgcolor="black" align="center">
<a href="http://bitacora.compuredes.com.co:8082/vista/login2.php"></a> 
<br> 
</td> 
</tr> 
</table> 
<br> 
<table width="100%" cellspacing="0" cellpadding="2" border="0"> 
<tr> 
<td valign="top"> 
<font face="verdana,arial,helvetica" size="3"> 
<p>Este mensaje fue enviado por:'.$nombre.' con el correo:'.$correo.'</p>
<p>'.$mensaje.'</p>
<br> 
<br>
<br> 
<br>
<br>  
</td></tr></table> 
</body> 
</html>
'; 

        
   //para el envio en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//direcciÃ³n del remitente 
$headers .= "From: Bitacora de operaciones <bitacora@arus.com.co>\r\n";  
        

$this_mail = mail("montoyamarlon14@gmail.com", $asunto, $cuerpo, $headers);

   
header("Location: ../../index.php");

}
?> 
