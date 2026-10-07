<?php
include("data_class.php");
$admin_email=$_POST['admin_email1'];
$admin_password_reg=$_POST['admin_password_reg1'];

if($admin_email== 'null'||$admin_password_reg=='null'){
    header("Location:index.php");
}
elseif($admin_email!= "null"||$admin_password_reg!= "null"){
$obj=new data();
$obj->setconnection();
$obj->adminlogin($admin_email,$admin_password_reg);
}
?>