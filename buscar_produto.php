<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 or $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}