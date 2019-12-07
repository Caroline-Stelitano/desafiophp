<?php
    session_start();

	if(!$_SESSION['usuario']){
		header('location:loginUsuario.php');
    }

    // ler arquivo
    $produtosJson = file_get_contents('./includes/produtos.json');
    $arrayProdutos = json_decode($produtosJson, true);

    $posicao = $_GET['produto'];

    //deletar imagem
    $produto = $arrayProdutos[$posicao];
    unlink($produto['foto']);
    
    //deletar produto
    unset($arrayProdutos[$posicao]);

    // transformar array em json
    $novoProdutosJson = json_encode($arrayProdutos);
    // salvar json no arquivo
    file_put_contents('./includes/produtos.json', $novoProdutosJson);

    header('location:indexProduto.php');
?>    