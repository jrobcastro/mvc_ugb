<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class model_usuarios extends CI_Model { 
 
 
	function traer_usuarios( $idusuarios=0 ){ 
		if( $idusuarios!=0 )$this->db->where('idusuarios', $idusuarios); 
		$query=$this->db->get('usuarios'); 
		return($query->num_rows()>0)?$query->result_array():false; 
	} 
 
 
	function save_usuario( $post ){ 
		$this->db->insert('usuarios', $post); 
		return($this->db->affected_rows()>0)?$this->db->insert_id():false; 
	} 
 
 
	function edit_usuario( $idusuarios, $post ){ 
		$this->db->where('idusuarios', $idusuarios); 
		return $this->db->update('usuarios', $post); 
	} 
 
 
	function delete_( $idusuarios ){ 
		$this->db->where('idusuarios', $idusuarios); 
		$this->db->delete('usuarios'); 
		return($this->db->affected_rows()>0)?true:false; 
	} 
 
}