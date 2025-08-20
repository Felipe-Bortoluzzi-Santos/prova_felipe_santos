<?php
session_start();
require_once('conexao.php');
//verifica se o usuario tem permissão de adm
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado');window.location='principal.php'</script)";
    exit();
}
//inicializa as variaveis
$usuarios=null;
//se o formulario for enviado, busca o usuario pelo id ou pelo nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_usuario'])){
        $busca=trim($_POST['busca']);
        //verifica se a busca é um numero (id) ou um nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM usuario WHERE id_usuario= :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM usuario WHERE nome= :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
        }
    }
}