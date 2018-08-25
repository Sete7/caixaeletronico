<?php
session_start();
require './config.php';

if (isset($_SESSION['banco']) && empty($_SESSION['banco']) == false):
    $id = $_SESSION['banco'];
    $sql = $pdo->prepare("SELECT * FROM contas WHERE id=:id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if ($sql->rowCount() > 0):
        $info = $sql->fetch();
    else:
        header('Location: login.php');
    endif;
else:
    header('Location: login.php');
endif;
?>
<h1>Welcome <?php echo $info['titular']; ?> </h1>
<h3>Agêcia : <?php echo $info['agencia']; ?></h3>
<h3>Conta: <?php echo $info['conta']; ?></h3>
<h3>Saldo: <?php echo $info['saldo']; ?></h3>
<a href="sair.php">Sair</a><br><br>

<hr><br>

<h1>Movimentação | Extrato</h1>
<a href="add-transacao.php">Adicionar Transação</a><br/><br/>
<table border="1" width="30%">
    <tr>
        <th>Data Transação</th>
        <th>Valor</th>
    </tr>
    <?php
    $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta=:id_conta");
    $sql->bindValue(":id_conta", $id);
    $sql->execute();

    if ($sql->rowCount() > 0):
        foreach ($sql->fetchAll() as $item):
            ?>
            <tr>
                <td><?php echo date("d/m/Y H:i", strtotime($item['data_operacao'])); ?></td>
                <td>
                    <?php if ($item['tipo'] == '0') : ?>                    
                    <span style="color:green;">R$ <?php echo $item['valor']; ?></span>                        
                    <?php else: ?>
                    <span style="color:#ff0000;"> - R$ <?php echo $item['valor']; ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
        endforeach;
    endif;
    ?>
</table>