<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class usuarios extends CI_Controller { 
 
 
	public function __construct(){ 
		parent::__construct(); 
		session_start(); 
		$this->load->model('model_usuarios'); 
	} 
 
 
 
	public function index(){	 
		if ( !isset($_SESSION['my_usuario']) )redirect( 'acceso', 'refresh' ); 
		$data['usuario']=$_SESSION['my_usuario']; 
		$data['page']   ='view_usuarios'; 
		$this->load->view('plantilla', $data); 
	} 
 
 
 
	function traer_lista(){ 
		$data=array(); 
		$data['lista']=$this->model_usuarios->traer_usuarios(); 
		if( $data['lista']==false ){ 
			$data['type']   =false; 
			$data['message']='No hay usuarios.'; 
		}else{ 
			$data['type']=true; 
		} 
		$this->output->set_content_type('application/json')->set_output( json_encode( $data ) ); 
	} 
 
 
 
	function traer_usuario(){ 
		$data=array(); 
		$idusuarios=(int)$this->input->post('idusuarios'); 
		if( $idusuarios==0 ){ 
			$data['type']   =false; 
			$data['message']='El parámetro idusuarios falló.'; 
		}else{ 
			$data['usuario']=$this->model_usuarios->traer_usuarios( $idusuarios ); 
			if( $data['usuario']==false ){ 
				$data['type']   =false; 
				$data['message']='No se encontró el usuario.'; 
			}else{ 
				$data['type']=true; 
			} 
			$this->output->set_content_type('application/json')->set_output( json_encode( $data ) ); 
		} 
	} 
 
 
 
	function save_form(){ 
		$data=array(); 
		$this->form_validation->set_rules('usuario', 'usuario', 'trim|required|xss_clean'); 
		$this->form_validation->set_rules('nombre', 'nombre', 'trim|required|xss_clean'); 
		$this->form_validation->set_rules('genero', 'genero', 'trim|required|xss_clean'); 
 
		$idusuarios=(int)$_POST['idusuarios'];  
		unset($_POST['idusuarios']); 
 
		if( $idusuarios==0 ){ 
			$this->form_validation->set_rules('clave', 'clave', 'required|matches[clave_]|xss_clean|md5'); 
		}else{ 
			$this->form_validation->set_rules('clave', 'clave', 'matches[clave_]|xss_clean|md5'); 
		} 
 
		$this->form_validation->set_message('matches', 'Las claves no coinciden'); 
		$this->form_validation->set_message('required', 'campo %s requerido'); 
 
		if( $this->form_validation->run() === FALSE ){ 
			$data['type']   =false; 
			$data['message']=validation_errors(); 
		}else{ 
			unset($_POST['clave_']); 
			if( $idusuarios==0 ){ 
				$hecho=$this->model_usuarios->save_usuario( $_POST ); 
			}else{ 
				if( $_POST['clave']==''||$_POST['clave']==null)unset($_POST['clave']); 
				$hecho=$this->model_usuarios->edit_usuario( $idusuarios, $_POST ); 
			} 
			if( $hecho==false ){ 
				$data['type']   =false; 
				$data['message']='No se pudo guardar el usuario.'; 
			}else{ 
				$data['type']      =true; 
				$data['message']   ='El usuario ha sido guardado.'; 
				$data['idusuarios']=($idusuarios==0)?$hecho:$idusuarios; 
			} 
		} 
		$this->output->set_content_type('application/json')->set_output( json_encode( $data ) ); 
	} 
 
 
	function delete_(){ 
		$data=array(); 
		$idusuarios=(int)$this->input->post('idusuarios'); 
		if( $idusuarios==0 ){ 
			$data['type']   =false; 
			$data['message']='El parámetro idusuarios falló.'; 
		}else{ 
			$hecho=$this->model_usuarios->delete_( $idusuarios ); 
			if( $hecho==false ){ 
				$data['type']   =false; 
				$data['message']='No se pudo eliminar.'; 
			}else{ 
				$data['type']   =true; 
				$data['message']='Usuario eliminado.'; 
			} 
		} 
		$this->output->set_content_type('application/json')->set_output( json_encode( $data ) ); 
	} 
 
}