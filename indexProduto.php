<?php

    session_start(); 
    
    if(!isset($_SESSION['usuario'])) {
		header('Location: loginUsuario.php');
	}

    $produtosJson = file_get_contents('includes/produtos.json');
	$produtos = json_decode($produtosJson, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/createProduto.css">
</head>
<body>
    <?php include('./includes/navbar.php');?>

    <main>
		<h3>Olá, <?= $_SESSION['usuario']['nome']; ?></h3>
        <div class="row justify-content-center mt-4" style="height: 100px;">
            <h4 class="align-self-center">Produtos</h4>
        </div>
        
		<section class="p-3">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Informações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($produtos as $i=>$produto): ?>
                    <tr>
                        <td><?= $produto['nome'] ?></td>
                        <td><?= $produto['descricao'] ?></td>
                        <td><?= $produto['preco'] ?></td>
                        <td><a href="showProduto.php?produto=<?= $i ?>" class="btn btn-warning">Ver mais</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>           				
		</section>
	</main>

</body>
</html>