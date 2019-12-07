<?php

    session_start(); 
        
    if(!isset($_SESSION['usuario'])) {
        header('Location: loginUsuario.php');
    }

    $erro_nome = false;
    $erro_email = false;
    $erro_senha = false;
    $erro_confirmasenha = false;
                                
    // ler arquivo
    $usuariosJson = file_get_contents('./includes/usuarios.json');
    $arrayUsuarios = json_decode($usuariosJson, true);

    if($_POST){

        //validações
        if(!$_POST['nome']){
            $erro_nome = true;
        }

        if(!$_POST['email']){
            $erro_email = true;
        }

        if($_POST['senha'] != $_POST['confirmasenha']){         //erro de confirmação de senha
            $erro_confirmasenha = true;
        }

        $senha = $_POST['senha'];       //erro de mín. 6 caracteres
        if(strlen($senha) < 6){         
            $erro_senha = true;
        }

        if(!$erro_nome && !$erro_email && !$erro_senha && !$erro_confirmasenha) {

            // criptografando senha
            $hash = password_hash($senha, PASSWORD_DEFAULT);

            // montar novo usuario
            $novoUsuario = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $hash
            ];

            // adicionar usuario no array
            $arrayUsuarios[] = $novoUsuario;
            // transformar array em json
            $novoUsuarioJson = json_encode($arrayUsuarios);
            // salvar json no arquivo
            file_put_contents('./includes/usuarios.json', $novoUsuarioJson);

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/createProduto.css">
</head>
<body>
    <?php include('./includes/navbar.php'); ?>
    <main class="container">
        <div class="row justify-content-center mt-5" style="height: 100px;">
            <span class="align-self-center">
                <h4>Cadastro de usuário</h4>
            </span>
        </div>
        <div class="conteudo">
            <form id='cadastro' method='POST' action=''>
                <div class="form-group m-3 w-50">
                    <label for="nome">Nome Completo</label>
                    <input type="name" class="form-control <?php if($erro_nome){echo('is-invalid');}?>" id="nome" name="nome" placeholder="digite o nome completo...">
                    <?php if($erro_nome): ?>
                        <div class= "invalid-feedback">Nome não preenchido</div>
                    <?php endif ?>
                </div>
                <div class="form-group m-3 w-50">
                    <label for="email">Email</label>
                    <input type="email" class="form-control <?php if($erro_email){echo('is-invalid');}?>" id="emailuser" name="email" placeholder="digite o email...">
                    <?php if($erro_email): ?>
                        <div class= "invalid-feedback">Email não preenchido</div>
                    <?php endif ?>
                </div>
                <div class="form-group m-3 w-50">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control <?php if($erro_senha){echo('is-invalid');}?>" id="senhauser" name="senha" placeholder="digite a senha...">
                    <?php if($erro_senha): ?>
                        <div class= "invalid-feedback">A senha deve ter ao menos 6 caracteres</div>
                    <?php endif ?>
                </div>
                <div class="form-group m-3 w-50">
                    <label for="confirmasenha">Confirme a senha</label>
                    <input type="password" class="form-control <?php if($erro_confirmasenha){echo('is-invalid');}?>" id="confirmsenhauser" name="confirmasenha" placeholder="confirme a senha...">
                    <?php if($erro_confirmasenha): ?>
                        <div class= "invalid-feedback">Senha incorreta</div>
                    <?php endif ?>
                </div>
                <div class="form-group form-check m-3 w-50">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">salvar dados</label>
                </div>
                <button type="submit" class="btn btn-warning m-3">Cadastrar</button>
            </form>
        </div>
        <section class="p-3">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($arrayUsuarios as $i=>$usuario): ?>
                    <tr>
                        <td><?= $usuario['nome'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><a class="btn btn-danger btn-xs" href="deleteUsuario.php?usuario=<?= $i ?>" data-toggle="modal" data-target="#delete-modal">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>           				
		</section>
    </main>
</body>
</html>