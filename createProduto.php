<?php

    session_start();

	if(!$_SESSION['usuario']){
		header('location:loginUsuario.php');
    }
    
    $erro_nome = false;
    $erro_foto = false;
    $erro_preco = false;

    if($_POST){

        //validações
        if(!$_POST['nomeproduto']){
            $erro_nome = true;
        }

        if($_POST['precoproduto'] && !is_numeric($_POST['precoproduto'])){
            $erro_preco = true;
        }
        
        $file = $_FILES['fotoproduto'];
        if($file['error'] == 4){
            $erro_foto = true;
        }

        if(!$erro_nome && !$erro_preco && !$erro_foto){

            //upload
            if ($file['error'] == 0){
                $nomeFoto = $file['name'];
                $caminhoTmp = $file['tmp_name'];
                $caminhoFoto = './img/' . $nomeFoto;
                move_uploaded_file($caminhoTmp, $caminhoFoto);
            }
            
            // ler arquivo
            $produtosJson = file_get_contents('./includes/produtos.json');
            $arrayProdutos = json_decode($produtosJson, true);

            // montar novo produto
            $novoProduto = [
                'nome' => $_POST['nomeproduto'],
                'descricao' => $_POST['descricaoproduto'],
                'preco' => $_POST['precoproduto'],
                'foto' => $caminhoFoto
            ];

            // adicionar produto no array
            $arrayProdutos[] = $novoProduto;
            // transformar array em json
            $novoProdutosJson = json_encode($arrayProdutos);
            // salvar json no arquivo
            file_put_contents('./includes/produtos.json', $novoProdutosJson);

            header('location:indexProduto.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>createProduto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/createProduto.css">
</head>

<body>
    
    <?php include('./includes/navbar.php');?>
    
    <main class="container">
        <div class="row d-flex justify-content-center mt-5" style="height: 100px;">
            <span class="align-self-center">
                <h4>Cadastre seu produto</h4>
            </span>
        </div>
        <div class="conteudo">
            <form id='registro' method='POST' action='' enctype="multipart/form-data">
                
                <div class="form-group m-3 w-50">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" class="form-control <?php if($erro_nome){echo('is-invalid');}?>" name="nomeproduto" id="nome" placeholder="digite o nome..." />
                    <?php if($erro_nome): ?>
                        <div class= "invalid-feedback">Nome não preenchido</div>
                    <?php endif ?>
                </div>
                
                <div class="form-group m-3 w-50">
                    <label for="descricao">Descrição do Produto</label>
                    <textarea class="form-control" name="descricaoproduto" id="descricao" rows="3" placeholder="digite a descrição..."></textarea>
                </div>
                
                <div class="form-group m-3 w-50">
                    <label for="preco">Preço do Produto</label>
                    <input type="text" class="form-control <?php if($erro_preco){echo('is-invalid');}?>" name="precoproduto" id="preco" placeholder="digite o preço..."/>
                    <?php if($erro_preco): ?>
                        <div class= "invalid-feedback">Preço deve ser um número</div>
                    <?php endif ?>
                </div>   
                
                <div class="form-group m-3">
                    <label for="foto">Foto upload:</label>
                    <input type="file" class="form-control-file <?php if($erro_foto){echo('is-invalid');} ?>" name="fotoproduto" id="foto" />
                    <?php if($erro_foto): ?>
                        <div class= "invalid-feedback">Foto não anexada</div>
                    <?php endif ?>
                </div>
                
                <button type="submit" class="btn btn-warning m-3">Enviar</button>
            </form>
        </div>
    </main>

</body>
</html>