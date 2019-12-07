<?php
    session_start();

	if(!$_SESSION['usuario']){
		header('location:loginUsuario.php');
    }

    // ler arquivo
    $usuariosJson = file_get_contents('./includes/usuarios.json');
    $arrayUsuarios = json_decode($usuariosJson, true);

    $posicao = $_GET['usuario'];
    
    //deletar usuario
    unset($arrayUsuarios[$posicao]);

    // transformar array em json
    $novoUsuariosJson = json_encode($arrayUsuarios);
    // salvar json no arquivo
    file_put_contents('./includes/usuarios.json', $novoUsuariosJson);

    header('location:cadastroUsuario.php');
?>    