<?php
session_start();
if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloBD.php';
    include_once '../Modelo/ModeloCategoria.php';
    include_once '../Clases/Categoria.php';
    $idtorneo=$_GET['idtorneo'];
    $idCategoria=$_GET['idCategoria'];
    $modalidad=$_GET['modalidad'];
    $edad=$_GET['edad'];        
    $sexo=$_GET['sexo'];
    $peso=$_GET['peso'];
    $estado=(int)$_GET['estado'];
    $modeloCategoria = new ModeloCategoria();
    
    if($estado==1){
        $categoria=new Categoria($idCategoria, $idtorneo, $sexo, $peso, $edad, $modalidad, 0);
    }else{
        $categoria=new Categoria($idCategoria, $idtorneo, $sexo, $peso, $edad, $modalidad, 1);
    }
    $modeloCategoria->modificarCategoria($categoria);
    header("Location: administrarCategorias.php?idtorneo=$idtorneo");

}else{
    header("Location: ../index.php");
}
