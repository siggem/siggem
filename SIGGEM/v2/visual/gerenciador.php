<?php
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/**/   //CONECTA COM O BANCO E STARTA A SESSAO
/**/   include "conexao.php";
/**/   session_start();
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/**/    //dados a receber via post
/**/   $nome = $_POST['nome'];
/**/   $email = $_POST['email'];
/**/   $senha = $_POST['senha'];
/**/   //criptografa a senha
/**/   $criptografia = md5($senha);
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/**/    //CONFIGURAÇÕES PARA GERAR LOG DE EVENTOS 
/**/	if($_POST['btn_acao'] == ""){
/**/   		$email = $_SESSION['login'];
/**/   		$log = "Saiu do Sistema";
/**/	}else{
/**/   		$log = $_POST['btn_acao'];
/**/	}
/**/   		$evento = $log;
/**/   		$ip = $_SERVER["REMOTE_ADDR"];
/**/   		$data = date('l jS \of F Y h:i:s A');
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
// VEREFICA SE O USUARIO JA ESTA COM SESSAO INICIADA DE TIVER REDIRECIONA PARA O PAINEL
/**/    if((!isset ($_SESSION['login']) == true)){
/**/        unset($_SESSION['login']);                     
/**/    } else {
/**/        header('location:/visual/painel/index.php');
/**/    }
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
// AUTENTICA O LOGIN DO USUARIO E REGISTRA O LOG DE EVENTOS
/**/    if($_POST['btn_acao']=="login"){
/**/    	$sql = $dbcon-> query("SELECT * FROM tb_usuario WHERE email='$email' AND senha='$criptografia'");         
/**/    	if(mysqli_num_rows($sql) > 0){
/**/        	//salva o evento no banco de dados
/**/        	$dbcon->query("INSERT INTO tb_log(usuario,evento,ip,horario) VALUES('$email','$evento','$ip','$data')");
/**/            //inicia a sessão e redireciona para o painel
/**/            $_SESSION['login'] = $email;
/**/            header('location:/visual/painel/index.php');
/**/        } else {
/**/        	echo "<h4>E-mail ou Senha invalido</h4>";
/**/        }
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
// SALVA O NOVO CADASTRO E REGISTRA O LOG DE EVENTOS
/**/    } else if($_POST['btn_acao']=="cadastro"){
/**/    	$sql1 = $dbcon->query("SELECT * FROM tb_usuario WHERE email='$email'");
/**/        if(mysqli_num_rows($sql1) > 0){
/**/        	echo "<h4>E-mail Já Cadastrado, Tente recuperar Sua Senha</h4>";
/**/        } else {
/**/        	$sql2 = $dbcon->query("INSERT INTO tb_usuario(nome,email,senha) VALUES('$nome','$email','$criptografia')");
/**/        	if($sql2){
/**/            	//salva o evento no banco de dados
/**/        		$dbcon->query("INSERT INTO tb_log(usuario,evento,ip,horario) VALUES('$email','$evento','$ip','$data')");
/**/              	//inicia a sessão e redireciona para o painel
/**/                $_SESSION['login'] = $email;
/**/                header('location:/visual/painel/index.php');
/**/            } else {
/**/               echo "Não foi possivel Realizar o cadastro !";
/**/            }
/**/        }
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/**/    } else if($_POST['btn_acao']=="recuperar"){
/**/        //codigo para recuperação de senha
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
// ENCERRA A SEÇÃO, REGISTRA O LOG DE EVENTOS E VAI PARA A PAGINA INICIAL DO SITE
/**/    }else{
/**/    	//salva o evento no banco de dados
/**/       	$dbcon->query("INSERT INTO tb_log(usuario,evento,ip,horario) VALUES('$email','$evento','$ip','$data')");
/**/        session_destroy();
/**/        header('location:/');
/**/    }
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
?>