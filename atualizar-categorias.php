<div class="container">
    <h2>Atualizar Categoria</h2>
    <?php
    $idCategoria = $_POST["idCategoria"];
    $nomeCategoria = $_POST["nomeCategoria"];

    $sql = "update tbCategorias set 
nomeCategoria='{$nomeCategoria}'
where idCategoria = '{$idCategoria}'
";
    $rs = mysqli_query($conexao, $sql);
    echo "<p>Registro atualizado com sucesso!</p>";
    ?>
</div>