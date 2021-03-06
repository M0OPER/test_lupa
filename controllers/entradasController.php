<?php
//Llamada al modelo
require_once("../models/entradasModel.php");

class EntradasController{

	private $entrada;

	public function __CONSTRUCT(){
    $this->entrada = new EntradasModel();
  }

  public function todas(){ // En este caso index va a mostrar todas las entradas
    $datos = $this->entrada->listar_entradas();
    require_once("../components/entradas_todas.php");
  }

  public function userId($id){ // En este caso index va a mostrar todas las entradas
    $datos = $this->entrada->entradas_idUser($id);
    require_once("../components/entradas_usuario.php");
  }

  public function entradaId($id){ // En este caso index va a mostrar todas las entradas
    $datos = $this->entrada->entradas_idEntrada($id);
    require_once("../components/entradas_detalle.php");
  }

  public function registrar(){ 
    $titulo      = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $imagen      = isset($_FILES['imagen']) ? $_FILES['imagen'] : '';
    $autor       = isset($_POST['autor']) ? $_POST['autor'] : '';
    $uploadDir    = __DIR__.'/../uploads/';
    $filesInput   = $_FILES['imagen'];
    $filesName    = $filesInput['name'];
    $filesTmpName = $filesInput['tmp_name'];
    $filesError   = $filesInput['error'];
    if ($titulo == '' || $descripcion == "" || $autor == "") {
      return json_encode(array("res" => false, "men" => "Verifica que los campos no esten vacíos"));
    }else{
      if ($filesError == \UPLOAD_ERR_OK) {
        $toPath = $uploadDir . uniqid() . '_' . $name .'.jpg';
        $uploaded = move_uploaded_file($filesTmpName, $toPath);
        $datos = $this->entrada->registrar_entrada($titulo, $descripcion, $toPath, $autor, $_SESSION["id"]);
        if ($datos) {
          return json_encode(array("res" => true, "men" => "Entrada registrado con exito"));
        }else{
          return json_encode(array("res" => false, "men" => "Error al crear la entrada"));
        }
      }else{
        return json_encode(array("res" => false, "men" => "Error al guardar imagen"));
      }
    }
  }

  public function eliminar(){ // En este caso index va a mostrar todas las entradas
    $id      = isset($_POST['id']) ? $_POST['id'] : '';
    $datos = $this->entrada->eliminar_entrada($id, $_SESSION["id"]);
    if ($datos) {
      return json_encode(array("res" => true, "men" => "Entrada eliminada con exito"));
    }else{
      return json_encode(array("res" => false, "men" => "Error al eliminar la entrada"));
    }
  }

  public function cargar(){ // En este caso index va a mostrar todas las entradas
    $id      = isset($_POST['id']) ? $_POST['id'] : '';
    $datos = $this->entrada->cargar_entrada($id, $_SESSION["id"]);
    if ($datos == false) {
      return json_encode(array("res" => false, "men" => "Error al cargar la entrada"));
    }else{
      return json_encode(array("res" => true, "men" => "Entrada cargada con exito", "data" => $datos));
    }
  }

  public function editar(){ // En este caso index va a mostrar todas las entradas
    $id          = isset($_POST['id']) ? $_POST['id'] : '';
    $titulo      = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $imagen      = isset($_FILES['imagen']) ? $_FILES['imagen'] : '';
    $autor       = isset($_POST['autor']) ? $_POST['autor'] : '';
    $uploadDir    = __DIR__.'/../uploads/';
    $filesInput   = $_FILES['imagen'];
    $filesName    = $filesInput['name'];
    $filesTmpName = $filesInput['tmp_name'];
    $filesError   = $filesInput['error'];
    if ($titulo == '' || $descripcion == "" || $autor == "") {
      return json_encode(array("res" => false, "men" => "Verifica que los campos no esten vacíos"));
    }else{
      if ($filesTmpName == '') {
        $datos = $this->entrada->editar_textos($titulo, $descripcion, $autor, $id, $_SESSION["id"]);
        if ($datos) {
          return json_encode(array("res" => true, "men" => "Editado con exito"));
        }else{
          return json_encode(array("res" => false, "men" => "Error al editar la entrada"));
        }
      }else{
        $toPath = $uploadDir . uniqid() . '_' . $name .'.jpg';
        $uploaded = move_uploaded_file($filesTmpName, $toPath);
        $datos = $this->entrada->editar_todo($titulo, $descripcion, $toPath, $autor, $id, $_SESSION["id"]);
        if ($datos) {
          return json_encode(array("res" => true, "men" => $toPath));
        }else{
          return json_encode(array("res" => false, "men" => "Error al editar la entrada"));
        }
      }
    }
  }

}


?>
