<script> 
			/** 
    		* Muestra una ventana emergente 
     		* con un mensaje especificado 
     		*/ 
    		function dialogo(title ,message){ 
				$('.notify').html( message ); 
				$( "#dialogo" ).dialog({ 
		    		autoOpen  : true, 
		    		width     : 400, 
		    		title     : title, 
		    		"position": ['middle',30], 
		    		modal     : true, 
		    		resizable : false, 
		    		buttons   : { 
		        		"Cerrar": function() { 
		            		$(  "#dialogo" ).dialog( "close" ); 
		        		} 
		    		}, 
		    		open: function(){}, 
		    		close: function(){} 
				}); 
			}; 
			/** 
	 		* Muestra una alerta 
	 		* Si recibe solo msj la alerta es amariila 
	 		* Si recibe msj y estado = true, la alerta es verde 
	 		* Si recibe msj y estado = false, la alerta es roja 
	 		* Si no recibe parametro limpia la alerta 
	 		*/ 
			function alerta(msj, estado){ 
				if( msj == null && estado == null ){ $('#msj').empty(); return; } 
				if( estado == null ){ 
					$('#msj').empty().html('<div class="alert alert-warning">'+ msj +'</div>'); 
				}else if( estado == true ){ 
           		 	$('#msj').empty().html('<div class="alert alert-success">'+ msj +'</div>'); 
        		}else if ( estado == false ){ 
            		$('#msj').empty().html('<div class="alert alert-danger">'+ msj +'</div>'); 
        		} 
    		} 
		</script> 
 
		<script src="js/jquery-1.11.0.min.js"></script> 
		<script src="js/bootstrap.min.js"></script> 
		<!-- JQUERY UI --> 
		<script src="js/jquery-ui-1.10.4.custom.js"></script> 
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script> 
	</body> 
</html>