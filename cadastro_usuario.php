<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1){
    echo "Acesso Negado";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $nome=$_POST['nome'];
    $email=$_POST['email'];
    $senha=password_hash($_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil=$_POST['id_perfil'];
    $sql="INSERT INTO usuario(nome,email,senha,id_perfil) VALUES (:nome,:email,:senha,:id_perfil)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":email",$email);
    $stmt->bindParam(":senha",$senha);
    $stmt->bindParam(":id_perfil",$id_perfil);
    if($stmt->execute()){
        echo"<script>alert('usuario cadastrado com sucesso!');</script>";
    } else {
        echo"<script>alert('erro ao cadastrar o usuario');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuarios</title>
    <link rel="stylesheet" href="stles.css">
</head>
<body>
    <h2>Cadastrar Usuario</h2>
    <form action="cadastro_usuario.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
    </form>
</body>
</html>