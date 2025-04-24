<div class="container">
    <h3>Cadastro de novo Cliente</h3>

    <form action="index.php?menu=inserir-clientes" method="post">
        <div>
            <label for="nomeCliente">Nome da Cliente</label>
            <input type="text" name="nomeCliente" id="nomeCliente">
        </div>
        <div>
            <label for="telefoneCliente">Telefone</label>
            <input type="text" name="telefoneCliente" id="telefoneCliente">
        </div>
        <div>
            <label for="emailCliente">E-Mail</label>
            <input type="email" name="emailCliente" id="emailCliente">
        </div>

        <div>
            <input type="submit" value="Salvar">
        </div>
    </form>
</div>