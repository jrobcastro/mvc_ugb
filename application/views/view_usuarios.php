<div class="container-fluid"> 
 
	<button type="button" onclick="prepara_form( 'Nuevo', 0 )" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar usuario</button> 
 
	<!-- TABLA DE USUARIOS --> 
	<table class="completa table"> 
		<thead> 
			<tr> 
				<th>Nombre</th> 
				<th>Usuario</th> 
				<th>Genero</th> 
				<th></th> 
			</tr> 
		</thead> 
		<tbody id="lista"></tbody> 
	</table> 
 
</div><!-- FIN CONTAINER --> 
 
<!-- FORMULARIO --> 
<div class="hide_" id="div_form"> 
	<div class="red" id="msj_form"></div> 
	<?php echo form_open('', array('id'=>'my_form')) ?> 
		<!-- HIDDEN --> 
		<input type="hidden" name="idusuarios" id="idusuarios"> 
		<table class="completa"> 
			<tr> 
				<td><label for="nombre">Nombre: *</label></td> 
				<td> 
					<input type="text" class="form-control" name="nombre" id="nombre"> 
				</td> 
			</tr> 
			<tr> 
				<td width="30%"><label for="usuario">Usuario: *</label></td> 
				<td width="70%"> 
					<input type="text" class="form-control" id="usuario" name="usuario"> 
				</td> 
			</tr> 
			<tr> 
				<td><label for="clave">Clave: *</label></td> 
				<td> 
					<input type="password" class="form-control" id="clave" name="clave"> 
				</td> 
			</tr> 
			<tr> 
				<td><label for="clave_">Confirmar clave: *</label></td> 
				<td> 
					<input type="password" class="form-control" id="clave_" name="clave_"> 
				</td> 
			</tr> 
			<tr> 
				<td><label for="genero">Genero: *</label></td> 
				<td> 
					<select name="genero" id="genero" class="form-control"> 
						<option value="">Seleccione</option> 
						<option value="m">Masculino</option> 
						<option value="f">Femenino</option> 
					</select> 
				</td> 
			</tr> 
		</table> 
	<?php echo form_close() ?> 
</div> 
 
<script> 
	var img='<i class="glyphicon glyphicon-dashboard"></i>'; 
 
	setTimeout(function(){ traer_lista(); }, 500); 
 
	function traer_lista(){ 
		$.ajax({ 
			url      : 'usuarios/traer_lista', 
			type     : 'post', 
			dataType : 'json', 
			beforeSend : function(){ 
				alerta( img + ' Espere...' ); 
			}, 
			success : function(data){ 
				alerta(); $('#lista').empty(); 
				if( data.type==false){ 
					alerta( data.message, false ); 
				}else{ 
					var genero=new Array(); genero['m']='Masculino'; genero['f']='Femenino'; 
					var fila=''; 
					$.each(data.lista, function( k, v ){ 
						fila  ='<tr tabindex="2014'+v.idusuarios+'" >'; 
						fila +='<td>'+v.nombre+'</td>'; 
						fila +='<td>'+v.usuario+'</td>'; 
						fila +='<td>'+genero[ v.genero ]+'</td>'; 
						fila +='<td>'; 
						fila += '<i class="glyphicon glyphicon-pencil" onclick="prepara_form(\'Editar\', '+v.idusuarios+')" title="EDITAR"></i>'; 
						fila +='<i class="glyphicon glyphicon-remove" onclick="confirm_delete( '+v.idusuarios+' )" title="ELIMINAR"></i>'; 
						fila +='</td>'; 
						fila +='</tr>'; 
						$('#lista').append(fila); 
					}); 
				} 
			}, 
			error : function(){ 
				alerta(); dialogo( 'Error', 'Error en la función usuarios/traer_lista.' ); 
			} 
		}); 
	}; 
 
	function prepara_form( accion, idusuarios ){ 
		$('#my_form')[0].reset(); 
		$('#genero option[value=""]').attr('selected', true); 
		$('#idusuarios').val( idusuarios ); 
		if( accion=='Editar' ){ 
			$.ajax({ 
				url      : 'usuarios/traer_usuario	', 
				type     : 'post', 
				dataType : 'json', 
				data     : { idusuarios : idusuarios }, 
				beforeSend : function(){ 
					alerta( img + ' Espere...' ); 
				}, 
				success : function(data){ 
					alerta(); 
					if( data.type==false ){ 
						dialogo('Notificación', data.message); 
					}else{ 
						var v=data.usuario[0]; 
						$('#usuario').val( v.usuario ); 
						$('#nombre').val( v.nombre ); 
						$('#genero option[value="'+v.genero+'"]').attr('selected', true); 
						load_form( accion ); 
					} 
				}, 
				error : function(){ 
					alerta(); dialogo( 'Error', 'Error en la función usuarios/traer_usuario.' ); 
				} 
			}); 
		}else{ 
			load_form( accion ); 
		} 
	};// ----------------------- 
	function load_form( accion ){ 
		$( "#div_form" ).dialog({ 
		    autoOpen  : true, 
		    width     : 600, 
		    title     : accion + ' usuario', 
		    "position": ['middle',30], 
		    modal     : true, 
		    resizable : false, 
		    buttons   : { 
		        "Cancelar": function() { 
		            $( "#div_form" ).dialog( "close" ); 
		        }, 
		        "Guardar": function(){ 
		    		save_form(); 
		    	} 
		    }, 
		    open: function(){}, 
		    close: function(){} 
		}); 
	};// --------------- 
	function save_form(){ 
		$.ajax({ 
			url      : 'usuarios/save_form', 
			type     : 'post', 
			dataType : 'json', 
			data     : $('#my_form').serialize(), 
			beforeSend : function(){ 
				$('#msj_form').html( img + ' Espere...' ); 
			}, 
			success : function(data){ 
				$('#msj_form').empty(); 
				if( data.type==false ){ 
					dialogo( 'Notificación', data.message ); 
				}else{ 
					$('#div_form').dialog('close'); 
					traer_lista(); 
					setTimeout(function(){  
						alerta(data.message, true);  
						$('tr[tabindex="2014'+data.idusuarios+'"]').focus(); 
					}, 1000); 
				} 
			}, 
			error : function(){ 
				$('#msj_form').empty(); dialogo( 'Error', 'Error en la función usuarios/save_form.' ); 
			} 
		}); 
	}; 
 
	function confirm_delete( idusuarios ){ 
		$('.notify').html( '¿Confirma que desea eliminar este usuario?' ); 
		$( "#dialogo" ).dialog({ 
		    autoOpen  : true, 
		    width     : 400, 
		    title     : 'Confirmación', 
		    "position": ['middle',30], 
		    modal     : true, 
		    resizable : false, 
		    buttons   : { 
		        "Cancelar": function() { 
		            $( "#dialogo" ).dialog( "close" ); 
		        }, 
		        "Eliminar": function(){ 
		        	$( "#dialogo" ).dialog( "close" ); 
		        	delete_( idusuarios ); 
		        } 
		    }, 
		    open: function(){}, 
		    close: function(){} 
		}); 
	};// -------------------------- 
	function delete_( idusuarios ){ 
		$.ajax({ 
			url      : 'usuarios/delete_', 
			type     : 'post', 
			dataType : 'json', 
			data     : { idusuarios : idusuarios }, 
			beforeSend : function(){ 
				alerta( img + ' Espere...' ); 
			}, 
			success : function( data ){ 
				alerta(); 
				if( data.type==false ){ 
					dialogo( 'Notificación', data.message ); 
				}else{ 
					$( "#dialogo" ).dialog( "close" ); 
					setTimeout(function(){ alerta( data.message, true ); }, 1000); 
					traer_lista(); 
				} 
			}, 
			error : function(){ 
				alerta(); dialogo( 'Error', 'Error en la función usuarios/delete_.' ); 
			} 
		}); 
	} 
</script> 
 
<style> 
	.red { color: red; min-height: 30px } 
	.completa { width: 100% } 
	.hide_ { display: none } 
	table td { padding: 5px } 
	table td i { margin: 5px } 
</style>