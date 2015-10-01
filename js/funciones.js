
				// $(document).ready(function () {			
					// $("div#makeMeScrollable").smoothDivScroll({
						// autoScrollingMode: "onStart"
					// });
					
				// });
				
				$(function() {
					$('#activator').click(function(){						
						$('#registro').fadeIn('fast',function(){
							$('#cuadroRegistro').animate({'top':'150%'},500);
						});
						//Devuelve falso para que no recargue la pag y muestre el desplegable del registro
						return false;
					});
					
					$('#activator').submit(function(){
						$('#registro').fadeIn('fast',function(){
							$('#cuadroRegistro').animate({'top':'150%'},500);
						});
					});
					$('#cierreCuadroRegistro').click(function(){
						$('#cuadroRegistro').animate({'top':'-1000px'},500,function(){
							$('#registro').fadeOut('fast');
						});
					});

				});
				
				function RegisterForm()
				{
					/*Comprobacion condiciones*/
					if (!document.forms["formulario"]["condiciones"].checked){						
						 alert("Debe aceptar las condiciones para continuar."); 
						 return false;
					} 
					/*Comprobacion del nombre*/
					var  nombre=document.forms["formulario"]["nombre"].value;
					if (nombre.length<1){
						alert("El nombre debe contener más de un caracter.");
						return false;
					}
					
					/*Comprobacion del usuario*/
					var  usuario=document.forms["formulario"]["usuario"].value;
					if (usuario.length<1){
						alert("El usuario debe contener más de un caracter.");
						return false;
					}
					
					 /*Comprobacion del correo*/
					var correo=document.forms["formulario"]["correo"].value;
					var atpos=correo.indexOf("@"); /*Debe contener @*/
					var dotpos=correo.lastIndexOf(".");
					if (atpos<1 || dotpos<atpos+2 || dotpos+2>=correo.length){
						alert("Correo inválido");
						return false;
					}
					
					/*Comprobacion pass*/
					var pass = document.forms["formulario"]["pass"].value;
					var passPrueba = document.forms["formulario"]["passPrueba"].value;
					var alfaNum = "abcdefghijklmnopqrstuvwxyz0123456789";
											if (pass.length<8){
						alert("La contraseña debe tener al menos 8 caracteres.");
						return false;
					}
					if(pass.indexOf(' ')== 0){
						alert("Contraseña incorrecta: no puede contener espacios");
						return false;                                                
					}
					for(var i=0; i<pass.length;i++){ /*si hay algun caracter que no sea alfanumerico devuelve error*/
						if(alfaNum.indexOf(pass.charAt(i))==-1){
							 alert("Contraseña incorrecta: debe contener caracteres alfanuméricos");
							return false;                                                
						}
					}                                             
					if(pass.localeCompare( passPrueba)){ /*Las dos contraseñas introducidas tienen que coincidir*/
						alert("Contraseña incorrecta: las dos contraseñas escritas no coinciden.");
						return false; 
					}					
					
					/*Comprobacion telefono*/
					var telefono = document.forms["formulario"]["tel"].value;
					var numeros = "0123456789";
					if (telefono.length<9){
						alert("El telefono debe contener al menos 9 números.");
						return false;
					}
					for(var i=0; i<telefono.length;i++){ /*si hay algun caracter que no sea numérico devuelve error*/
						if(numeros.indexOf(telefono.charAt(i))==-1){
							 alert("Telefono incorrecto: solo puede contener números.");
							return false;                                                
						}
					}						
					
					
				}
				
				function validaContacto ()
				{
						
						/*Comprobacion del nombre*/
						var  nombre=document.forms["formContacto"]["nombre"].value;
						if (nombre.length<3)
						{
							alert("El nombre debe contener más de un caracter.");
							return false;
						}
						
						 /*Comprobacion del correo*/
						var correo=document.forms["formContacto"]["correo"].value;
						var atpos=correo.indexOf("@"); /*Debe contener @*/
						var dotpos=correo.lastIndexOf(".");
						if (atpos<1 || dotpos<atpos+2 || dotpos+2>=correo.length)
						{							
							alert("Correo inválido");
							return false;
						}						
						
						
						/*Comprobacion telefono*/
						var telefono = document.forms["formContacto"]["tel"].value;
						var numeros = "0123456789";
						if (telefono.length<9){
							alert("El telefono debe contener al menos 9 números.");
							return false;
						}
						for(var i=0; i<telefono.length;i++){ /*si hay algun caracter que no sea numérico devuelve error*/
							if(numeros.indexOf(telefono.charAt(i))==-1){
								 alert("Telefono incorrecto: solo puede contener números.");
								return false;                                                
							}
						}						
						
						/*Comprobacion del mensaje*/
						var  mensaje=document.forms["formContacto"]["mensaje"].value;
						if (mensaje.length<1)
						{
							alert("El mensaje debe contener más de un caracter.");
							return false;
						}
				}
				
				

