<div class="container">
    <h2>Inserir Categoria</h2>
    <?php
    $nomeCategoria = $_POST["nomeCategoria"];


    $sql = "INSERT INTO tbcategorias (
    nomeCategoria
    )
    VALUES(
    '$nomeCategoria'
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