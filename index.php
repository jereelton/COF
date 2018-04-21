<?php
	
	// Tentando liberar a session caso ela exista
	session_start();
	
	if( isset( $_SESSION[ 'nome_lista' ] ) && $_SESSION[ 'nome_lista' ] <> "" ) {
		
		unset( $_SESSION[ 'nome_lista' ] );
		
	}
	
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	
	<title>COF</title>
	
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	
	<link rel="shortcut icon" type="image/x-icon" href="img/icone_sistema.png" />
	
	<link rel="stylesheet" href="css/estilos.css" type="text/css" />
	<link rel="stylesheet" href="css/estilos_360x640.css" type="text/css" />
	<link rel="stylesheet" href="css/estilos_640x360.css" type="text/css" />
	
</head>

<body>

<div id="div_conteiner_lista_compra">
	
	<!-- TELA PRETA PARA PROTECAO DO LAYOUT -->
	<div id="div_tela_preta"></div>
	
	<!-- DIV EXCLUIR -->
	<div id="div_excluir">
		
		<div id="div_header_excluir">
			<img src="img/alerta_amarelo.png" />
			<h2>Deseja mesmo exlcuir o item ?</h2>
		</div>
		
		<div id="nome_arquivo"></div>
		
		<p class="p_produto">
			<input type="button" class="input_button input_aplicar" onclick="return excluir_confirmado( 'div_excluir' );" />
			<input type="button" class="input_button input_fechar"  onclick="return fechar_elemento_simples( 'div_excluir' );" />
			
			<input type="hidden" id="input_hidden_excluir_lista" class="" name="" value="" />
		</p>
		
	</div>
	
	<!-- DIV MENSAGEM DE SUCESSO -->
	<div id="div_mensagens_sucesso">
		<div id="div_content_sucess"></div>
	</div>
	
	<!-- DIV MENSAGEM DE ERRO -->
	<div id="div_mensagens_erro">
		<div id="div_content_erro"></div>
	</div>
	
	<!-- DIV QUANDO CRIA UMA NOVA LISTA -->
	<div id="div_ver_lista_criada">
		
		<h3>Lista criada com sucesso !</h3>
		
		<img src="img/botao_sucesso.png" align="absmiddle" />
		
		<p>
			<a href="lista_compra.php">Acessar Lista Criada</a>
			<br />
			<a onClick="javascript: fechar_elemento('div_ver_lista_criada'); carregar_listas_salvas( 'div_mostra_listas_salvas' );">Ver Listas Salvas</a>
		</p>
		
	</div>

	<!--/////////////////// INICIO DO LAYOUT //////////////////////-->
	
	<h4>Controle de Opera&ccedil;&otilde;es Financeiras</h4>
	
	<!-- BOTAO PARA CRIAR NOVA LISTA -->
	<p id="p_nova_lista">
		<a onclick="javascript: abrir_elemento_relativamente( 'div_nova_lista' ); exec_focus( 'input_nome_nova_lista' );">Criar Nova Lista</a>
	</p>
	
	<!-- DIV PARA CRIAR NOVA LISTA, ABERTA PELO BOTAO ACIMA -->
	<div id="div_nova_lista">
	
		<form id="form_criar_nova_lista" method="POST" action="php/criar_nova_lista.php" onSubmit="return criar_nova_lista();">
		
			<p>
				Informe o nome da lista!
				<input class="input_text_divs" type="text" name="input_nome_nova_lista" id="input_nome_nova_lista" value="" autocomplete="off" />
			</p>
			
			<p>
				<input class="input_button input_aplicar" type="submit" value="" />
				<input class="input_button input_fechar"  type="reset"  value="" onclick="return fechar_elemento( 'div_nova_lista' );" />
				
				<input type="hidden" name="input_criar_nova_lista" value="CriarNovaLista" />
				<input type="hidden" name="input_hidden_guarda_contador" id="input_hidden_guarda_contador" value="1" />
			</p>
		
		</form>
	
	</div>
	
	<!-- DIV PARA MOSTRAR AS LISTAS SALVAS NO SISTEMA -->
	<div id="div_listas_salvas">
	
		<h5>Listas Salvas</h5>
		
		<div id="div_mostra_listas_salvas">
			<!-- INSERE AS LISTAS SALVAS AQUI -->
		</div>
	
	</div>
	
	<!--/////////////////// FIM DO LAYOUT //////////////////////-->

</div>

<script src="js/vars.js" type="text/javascript"></script>
<script src="js/shared.js" type="text/javascript"></script>

<script src="js/acessar_lista_salva.js" type="text/javascript"></script>
<script src="js/carregar_listas_salvas.js" type="text/javascript"></script>
<script src="js/criar_nova_lista.js" type="text/javascript"></script>
<script src="js/excluir_confirmado.js" type="text/javascript"></script>
<script src="js/lista_ja_existe.js" type="text/javascript"></script>

<script src="js/jquery.js" type="text/javascript"></script>

<!-- ESTA FUNCAO JS SERVE PARA CARREGAR DINAMICAMENTE AS LISTAS PELO OBJETO XMLHTTP -->
<script>carregar_listas_salvas( 'div_mostra_listas_salvas' );</script>

</body>
</html>
