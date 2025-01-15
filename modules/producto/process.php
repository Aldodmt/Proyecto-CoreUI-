<?php
session_start();
require_once "../../config/database.php";

if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3>";
}else{
    if($_GET['act']=='insert'){
        if(isset($_POST['Guardar'])){
            $codigo = $_POST['codigo'];
            $producto = $_POST['p_descrip'];
            $tipo_producto = $_POST['tipo_producto'];
            $u_medida = $_POST['u_medida'];
            $precio = $_POST['precio'];

            $query = mysqli_query($mysqli, "INSERT INTO producto (cod_producto, cod_tipo_prod, id_u_medida, p_descrip, precio) 
                                                          VALUES ($codigo, $tipo_producto, $u_medida, '$producto', $precio)") 
                                                          or die('error'.mysqli_error($mysqli));

            if($query){
                header("Location: ../../main.php?module=producto&alert=1");
            }else{
                header("Location: ../../main.php?module=producto&alert=4");
            }
        }
    }
    elseif($_GET['act']=='update'){
        if(isset($_POST['Guardar'])){
            if(isset($_POST['codigo'])){
                $codigo = $_POST['codigo'];
                $producto = $_POST['p_descrip'];
                $tipo_producto = $_POST['tipo_producto'];
                $u_medida = $_POST['u_medida'];
                $precio = $_POST['precio'];

                $query = mysqli_query($mysqli, "UPDATE producto SET cod_tipo_prod = $tipo_producto,
                                                                                  id_u_medida = $u_medida,
                                                                                  p_descrip = '$producto',
                                                                                  precio = $precio  
                                                                                  WHERE cod_producto= $codigo")
                                                                    or die('error'.mysqli_error($mysqli));
                
                if($query){
                    header("Location: ../../main.php?module=producto&alert=2");
                }else{
                    header("Location: ../../main.php?module=producto&alert=4");
                }
            }
        }
    }
    elseif ($_GET['act']=='delete') {
        if(isset($_GET['cod_producto'])){
            $codigo = $_GET['cod_producto'];
            
            $query = mysqli_query($mysqli, "DELETE FROM producto WHERE cod_producto = $codigo") or die('error'.mysqli_error($mysqli));

            if($query){
                header("Location: ../../main.php?module=producto&alert=3");
            }else{
                header("Location: ../../main.php?module=producto&alert=4");
            }
        }
    }
}