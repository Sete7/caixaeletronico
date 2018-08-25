<?php
session_start();
require './config.php';

if (isset($_POST['agencia']) && empty($_POST['agencia']) == false):
    $agencia = addslashes($_POST['agencia']);
    $conta = addslashes($_POST['conta']);
    $senha = md5($_POST['senha']);
    
    $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia=:agencia AND conta=:conta AND senha=:senha");
    $sql->bindValue(":agencia", $agencia);
    $sql->bindValue(":conta", $conta);
    $sql->bindValue(":senha", $senha);
    $sql->execute();
    
    if($sql->rowCount() > 0  ):
        $sql = $sql->fetch();
        $_SESSION['banco'] = $sql['id'];
        header('Location: index.php');
        exit();       
    endif;
    

endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Caixa Eletrônico</title>
    </head>
    <body>
        <h1>Painel de Login Caixa Eletrônico</h1>
        <form method="POST">
            Agência<br/>
            <input type="text" name="agencia"><br/><br/>
            Conta<br/>
            <input type="text" name="conta"><br/><br/>
            senha<br/>
            <input type="password" name="senha"><br/><br/>

            <input type="submit" value="Entrar">
        </form>        
    </body>
</html>