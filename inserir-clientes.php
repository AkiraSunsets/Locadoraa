<div class="container">
    <h2>Inserir Cliente</h2>
    <?php
    $nomeCliente = $_POST["nomeCliente"];
    $telefoneCliente = $_POST["telefoneCliente"];
    $emailCliente = $_POST["emailCliente"];


    $sql = "INSERT INTO tbClientes (
    nomeCliente,
    telefoneCliente,
    emailCliente
    )
    VALUES(
    '$nomeCliente',
    '$telefoneCliente',
    '$emailCliente'
    )
    ";
    $rs = mysqli_query($conexao, $sql);

    if ($rs) {
        echo "<p>Registro inserido com sucesso</p>";
    } else {
        echo "<p>Erro ao inserir</p>";
    }
    ?>
</div>