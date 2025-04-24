<div class="container">
    <h2>Excluir Cliente</h2>
    <?php
    $idCliente = $_GET["idCliente"];
    $sql = "delete from tbClientes where idCliente = '{$idCliente}'";
    $rs = mysqli_query($conexao, $sql);

    echo "<p>Registro excluido com sucesso!</p>";

    ?>
</div>