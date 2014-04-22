<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class model_acceso extends CI_Model { 
 
	function comprobar( $post ){ 
		$query=$this->db->get_where('usuarios', array('usuario'=>$post['usuario'], 'clave'=>$post['clave'])); 
		return($query->num_rows()>0)?$query->row_array():false;		 
	} 
 
}