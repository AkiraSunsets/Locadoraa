<?php
$idCategoria = $_GET["idCategoria"];
$sql = "SELECT * FROM tbcategorias WHERE idCategoria = '{$idCategoria}'";
$rs = mysqli_query($conexao, $sql) or die("Erro ao realizar a consulta. Erro: " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
?>
<div class="container">
    <h2>Editar categoria</h2>
    <form action="index.php?menu=atualizar-categorias" method="post">
        <div>
            <label for="idCategoria">ID</label>
            <input type="text" name="idCategoria" id="idCategoria" value="<?= $dados["idCategoria"] ?>" readonly>
        </div>

        <div>
            <label for="nomeCategoria">Nome da Categoria</label>
            <input type="text" name="nomeCategoria" id="nomeCategoria" value="<?= $dados["nomeCategoria"] ?>">
        </div>

        <div>
            <input type="submit" value="Salvar">
        </div>
    </form>
</div>