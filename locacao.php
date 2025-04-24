
<?php


$idCliente = (isset($_GET["idCliente"])) ? $_GET["idCliente"] : 0;

$idLocacao = (isset($_GET["idLocacao"])) ? $_GET["idLocacao"] : 0;

$idFilme = (isset($_GET["idFilme"])) ? $_GET["idFilme"] : 0;

$menuOpLocacao = (isset($_GET["menuOpLocacao"])) ? $_GET["menuOpLocacao"] : "";

$dataAtual = date('Y-m-d');

if(isset($_GET["dataDeEntrega"])) {
    $dataDeEntrega = $_GET["dataDeEntrega"];
} else {
    $dataDeEntrega = date("Y-m-d", strtotime($dataAtual . '+ 5 days'));
}

if($menuOpLocacao === "addLocacao") {
    $sql = "INSERT INTO tblocacao (idCliente,dataLocacao,statusLocacao)
    VALUES ('{$idCliente}','{$dataAtual}',0)";

    mysqli_query($conexao, $sql) or die("Erro:" . mysqli_error($conexao));

    $idLocacao = mysqli_insert_id($conexao);
    header('Location:index.php?menu=locacao&idCliente=' . $idCliente);
}

if($menuOpLocacao === "addVideo") {
   $sql = "INSERT INTO tbitenslocados(idLocacao, idFilme, dataDeEntrega)
   VALUES ('{$idLocacao}','{$idFilme}','{$dataDeEntrega}')";

   mysqli_query($conexao, $sql);

   $sql = "UPDATE tbfilmes SET statusFilme = 1 WHERE idFilme = '{$idFilme}'";
   mysqli_query($conexao, $sql);
}

if($menuOpLocacao === "removeVideo") {
    $sql = "DELETE FROM tbitenslocados WHERE idLocacao = '{$idLocacao}' and idFilme = '{$idFilme}'";
    mysqli_query($conexao, $sql);

    $sql = "UPDATE tbFilmes SET statusFilme = 0 WHERE idFilme = '{$idFilme}'";
    mysqli_query($conexao, $sql);
}

if($menuOpLocacao === "baixaVideo") {
    $sql = "UPDATE tbitenslocados SET statusItemLocado = 1
    WHERE idLocacao = '{$idLocacao}' and idFilme = '{$idFilme}'";
    mysqli_query($conexao, $sql);

    $sql = "UPDATE tbfilmes SET statusFilme = 0 WHERE idFilme = '{$idFilme}'";
    mysqli_query($conexao, $sql);
}

$sql = "SELECT * FROM tbitenslocados WHERE idLocacao = {$idLocacao}";
$rs = mysqli_query($conexao, $sql);
$linha = mysqli_num_rows($rs);

if($linha > 0) {
    $sql = "SELECT * FROM tbitenslocados
    WHERE idLocacao = $idLocacao and statusItemLocado = 0";
    $rs = mysqli_query($conexao, $sql);
    $linha = mysqli_num_rows($rs);
    if($linha == 0) {
        $sql = "UPDATE tblocacao SET statusLocacao = 1 WHERE idLocacao = {$idLocacao}";

        mysqli_query($conexao, $sql);
    }
}

?>

<h1>Locação</h1>
<div>
    <form action="" method="get">
        <input type="hidden" name="menu" value="locacao">

        <label for="idCliente">ID do Cliente</label>
        <select name="idCliente" id="idCliente">
            <?php
            $sql = "SELECT * FROM tbclientes WHERE statusCliente = 0";
            $rs = mysqli_query($conexao, $sql);
            while($dados = mysqli_fetch_assoc($rs)) {
                ?>
                <option
                    <?php echo ($idCliente == $dados["idCliente"]) ? "selected" : ""?>
                    value="<?= $dados['idCliente']?>">
                    <?= $dados['idCliente'] ?> - <?= $dados['nomeCliente'] ?>
                </option>
            <?php
            }
            ?>
        </select>
        <button type="submit">Listar locações para este cliente</button>
    </form>
</div>

<?php
if($idCliente > 0) {
    ?>
    <div class="box-locacao">
        <div>
            <h3>Lista de Locação</h3>
            <div>
                <a href="index.php?menu=locacao&idCliente=<?= $idCliente ?>&menuOpLocacao=addLocacao">
                Nova locação</a>
            </div>

            <table border="1">
                <thead>
                    <tr>
                        <th>id locação</th>
                        <th>Data de Locação</th>
                        <th>Status</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT
                    idLocacao,
                    date_format(dataLocacao, '%d/%m/%Y') as dataLocacao,
                    statusLocacao,
                    cli.idCliente
                        FROM tblocacao as loc
                        inner join tbclientes as cli on loc.idCliente = cli.idCliente
                        WHERE cli.idCliente = {$idCliente} order by statusLocacao asc, dataLocacao desc, idLocacao desc";
                        $rs = mysqli_query($conexao, $sql);
                        while($dados = mysqli_fetch_assoc($rs)) {
                            ?>
                            <tr>
                                    <td><?= $dados["idLocacao"]?></td>
                                    <td><?= $dados["dataLocacao"]?></td>
                                    <td><?= $dados["statusLocacao"]?></td>
                                    <td><a href="index.php?menu=locacao&idCliente=<?= $dados["idCliente"]?>&idLocacao=<?= $dados["idLocacao"]?>">
                                    Editar
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <?php
        if ($idLocacao > 0) {
            ?>
            <div>
                <div>
                    <h3>Locação atual</h3>
                    <form action="" method="get">
                        <input type="hidden" name="menu" value="locacao">
                        <input type="hidden" name="idLocacao" value="<?= $idLocacao?>">
                        <input type="hidden" name="idCliente" value="<?= $idCliente?>">
                        <input type="hidden" name="menuOpLocacao" value="addVideo">
                        <label for="">ID do Filme</label>
                        <select name="idFilme" id="idFilme" required>
                            <option value="">Selecione o video</option>
                            <?php
                            $sql = "SELECT * FROM tbfilmes
                            WHERE statusFilme = 0";
                            $rs = mysqli_query($conexao, $sql);
                            while ($dados = mysqli_fetch_assoc($rs)) {
                                ?>
                                <option value="<?= $dados["idFilme"]?>">
                                <?= $dados["idFilme"] ?> - <?= $dados["tituloFilme"] ?> 
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="date" name="dataDeEntrega" id="dataDeEntrega" value="<?= $dataDeEntrega?>">
                        <button type="submit">Add</button>
                    </form>
                </div>
                <div>
                    <a target="_blank" href="recibo-locacao.php?idClientes=<?=$idCliente?>&idLocacao=<?=$idLocacao?>&menuOpLocacao=imprimirLocacao">
                            Imprimir Recibo de Locação
                    </a>
                </div>
                <table border="1">
                    <thead>
                        <tr>
                            <th>id Video</th>
                            <th>Titulo Video</th>
                            <th>Data de Entrega</th>
                            <th>Status</th>
                            <th>Baixar</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sql = "SELECT f.idFilme,f.tituloFilme,
                        date_format(dataDeEntrega,'%d/%m/%Y') as dataDeEntrega,
                        CASE
                            WHEN statusItemLocado = 0 THEN 'Locado'
                            WHEN statusItemLocado = 1 THEN 'Devolvido'
                            WHEN statusItemLocado = 2 THEN 'Em atraso'
                        END
                        as statusItemLocado
                            FROM tblocacao as loc
                                inner join tbitenslocados as iloc
                                inner join tbfilmes as f on loc.idLocacao = iloc.idLocacao
                                and iloc.idFilme = f.idFilme
                                WHERE loc.idLocacao = {$idLocacao}";

                        $rs = mysqli_query($conexao, $sql);
                        while($dados = mysqli_fetch_assoc($rs)) {
                            ?>

                            <tr>
                                <td><?= $dados["idFilme"]?></td>
                                <td><?= $dados["tituloFilme"]?></td>
                                <td><?= $dados["dataDeEntrega"]?></td>
                                <td><?= $dados["statusItemLocado"]?></td>

                                <td>
                                    <a href="index.php?menu=locacao&idCliente=<?= $idCliente?>&idLocacao=<?=$idLocacao?>&menuOpLocacao=baixaVideo&idFilme=<?=$dados["idFilme"]?>">
                                        Baixar
                                    </a>
                                </td>

                                <td>
                                    <a href="index.php?menu=locacao&idCliente=<?= $idCliente?>&idLocacao=<?=$idLocacao?>&menuOpLocacao=removeVideo&idFilme=<?=$dados["idFilme"]?>">
                                        Remover
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
    <?php
}
?>