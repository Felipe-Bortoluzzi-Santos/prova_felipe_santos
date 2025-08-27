<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 or $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $id_produto=$_POST['id_produto'];
    $nome=$_POST['nome'];
    $descricao=$_POST['descricao'];
    $qtde=$_POST['qtde'];
    $valor_unit=$_POST['valor_unit'];
    $sql="UPDATE produto SET nome_prod= :nome , descricao= :descricao , qtde= :qtde , valor_unit= :valor_unit WHERE id_produto= :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindparam(":nome",$nome);
    $stmt->bindparam(":email",$descricao);
    $stmt->bindfloat(":id_perfil",$qtde);
    $stmt->bindfloat(":id_perfil",$valor_unit);
    $stmt->bindparam(":id",$id_produto);
    if($stmt->execute()) {
        echo "<script>alert('Produto atualizado com sucesso');window.location.href='buscar_produto.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o produto');window.location.href='alterar_produto.php?id=$produto';</script>";
    }
}
?>