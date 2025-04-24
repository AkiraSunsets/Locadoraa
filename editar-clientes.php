<?php
$idCliente = $_GET["idCliente"];
$sql = "SELECT * FROM tbclientes WHERE idCliente = '{$idCliente}'";
$rs = mysqli_query($conexao, $sql) or die("Erro ao realizar a consulta. Erro: " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
?>
<div class="container">
    <h2>Editar Cliente</h2>

    <form action="index.php?menu=atualizar-clientes" method="post">
        <div>
            <label for="idCliente">ID</label>
            <input type="text" name="idCliente" id="idCliente" value="<?= $dados["idCliente"] ?>" readonly>
        </div>
        <div>
            <label for="nomeCliente">Nome do Cliente</label>
            <input type="text" name="nomeCliente" id="nomeCliente" value="<?= $dados["nomeCliente"] ?>">
        </div>

        <div>
            <label for="telefoneCliente">Telefone</label>
            <input type="text" name="telefoneCliente" id="telefoneCliente" value="<?= $dados["telefoneCliente"] ?>">
        </div>

        <div>
            <label for="emailCliente">E-Mail</label>
            <input type="email" name="emailCliente" id="emailCliente" value="<?= $dados["emailCliente"] ?>">
        </div>

        <div>
            <input type="submit" value="Salvar">
        </div>
    </form>
</div>