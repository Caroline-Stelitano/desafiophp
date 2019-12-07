<?php 
    session_start(); 
    
    if ($_POST) {
        $usuariosJson = file_get_contents('./includes/usuarios.json');      //vejo se o login esta funcionando vendo se o formulario foi enviado
        $arrayUsuarios = json_decode($usuariosJson, true);                  //e se o usuario esta fazendo parte dos usuarios cadastrados:

        //uso foreach para percorrer os usuarios e verificar se o usuario esta cadastrado:
            foreach($arrayUsuarios as $usuario) {
                //preciso saber se o email que recebo no form existe na minha base. Verifico se email e senha batem. se sim, redireciona o usuario para o index, senão mostra a msg de erro. 
                if($_POST['email'] == $usuario['email'] && password_verify($_POST['senha'], $usuario['senha'])) {
                    //definindo um cookie: (caso o usario clique na checkbox de manter conectado). Pergunto dentro do if pois só vou salvar essa informação se os dados estiverem corretos
                    if($_POST['manter']== "on"){
                        setcookie('emailUsuario', $_POST['email']);  //parametro 1 é o nome do cookie, paramentro 2 é o valor do cookie
                        setcookie('senhaUsuario', $_POST['senha']);  //preciso fazer campo por campo, pois cookie so salva string, nunca array.
                    }
                    
                    $_SESSION['usuario'] = $usuario;    //definindo a sessão do usuário: crio variavel que guarda todas as infos do usuarios.
                    
                    return header('Location: indexProduto.php');
                } 
            }
            $erroLogin = 'usuario e/ou senha incorretos!';   //só executa essa linha se a linha do if for false.
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/createProduto.css">
</head>
<body>
    
    <main class="container">
        <div class="row d-flex justify-content-center mt-5" style="height: 100px;">
            <span class="align-self-center">
                <h4>Faça seu Login</h4>
            </span>
        </div>
        <div class="conteudo">
            <?php if(isset($erroLogin)) { ?>
                <div class="alert alert-danger"><?= $erroLogin ?></div>
            <?php } ?>
            <form id='login' method='POST' action=''>
                <div class="form-group m-3 w-50">
                    <label for="email">Email</label>
                    <input type="email" class="form-control <?php if(isset($_COOKIE['emailUsuario'])) {echo "value='$_COOKIE[emailUsuario]'";} ?>" id="emailuser" name="email" placeholder="digite seu email..."> 
                </div>
                <div class="form-group m-3 w-50">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control <?php if(isset($_COOKIE['senhaUsuario'])) {echo "value='$_COOKIE[senhaUsuario]'";} ?>" id="senhauser" name="senha" placeholder="digite sua senha..."> 
                </div>
                <div class="form-group form-check m-3 w-50">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">salvar dados</label>
                </div>
                <button type="submit" class="btn btn-warning m-3">Enviar</button>
            </form>
        </div>
    </main>
</body>
</html>