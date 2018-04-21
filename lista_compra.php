<?php
	
	session_start();
	
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

<?php

// Testa se a sessao esta ativa, caso nao esteja ativa bloqueia o acesso
if( ! isset( $_SESSION[ 'nome_lista' ] ) || $_SESSION[ 'nome_lista' ] == "" ) {
	
	echo "<body>";
	
	echo "<div id=\"div_tela_preta\"><br /><br /><br /><br /><br />";
	
	echo "Falha ao tentar carregar o conteudo, por favor acesse novamente !";
	echo "<br /><br /><br />";
	echo "<a href=\"index.php\">Inicio</a>";
	
	echo "</div>";
	
	echo "<script src=\"js/vars.js\"   type=\"text/javascript\"></script>";
	echo "<script src=\"js/shared.js\" type=\"text/javascript\"></script>";
	echo "<script src=\"js/jquery.js\" type=\"text/javascript\"></script>";
	
	echo "<script>abrir_elemento( 'div_tela_preta' );</script>";
	
	echo "</body>";
	echo "</html>";
	
	die("");
	
}

$nome_lista_ativa = $_SESSION[ 'nome_lista' ];

?>

<body>

<!-- DIV GERAL DO LAYOUT -->
<div id="div_conteiner_lista_compra">
	
	<!-- DIV PROTECAO DE TELA -->
	<div id="div_tela_preta"></div>
	
	<!-- DIV PARA MOSTRAR OS RECURSOS QUE FORAM APLICADOS NA OPERACAO -->
	<div id="div_ver_recursos">
		
		<h2>Recursos Aplicados</h2>
		
		<div id="div_mostra_recursos_aplicados">
			<!-- MOSTRA OS RECURSOS APLICADOS AQUI -->
		</div>
		
		<p class="p_fechar_menu">
			<a onclick="return fechar_elemento( 'div_ver_recursos' );">Fechar</a>
		</p>
		
	</div>
	
	<!-- DIV EXCLUIR RECURSO -->
	<div id="div_excluir_recurso">
		
		<div id="div_header_excluir_recurso">
			<img src="img/alerta_amarelo.png" />
			<h2>Deseja mesmo exlcuir o recurso ?</h2>
		</div>
		
		<div id="nome_recurso"></div>
		
		<p class="p_produto">
			<input type="button" class="input_button input_aplicar" onclick="return excluir_recurso_confirmado( 'div_excluir_recurso' );" />
			<input type="button" class="input_button input_fechar"  onclick="return fechar_elemento_simples( 'div_excluir_recurso' );" />
			
			<input type="hidden" id="input_hidden_excluir_recurso" class="" value="" name="" />
			<input type="hidden" id="input_hidden_valor_recurso" class="" value="" name="" />
		</p>
		
	</div>
	
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
			
			<input type="hidden" id="input_hidden_excluir_lista" class="" value="" name="" />
		</p>
		
	</div>
	
	<!-- DIV PARA ABRIR LISTAS SALVAS NO SISTEMA -->
	<div id="div_abrir_lista">
	
		<h2>Listas Salvas</h2>
		
		<div id="div_mostra_abrir_listas_salvas">
			<!--MOSTRA AS LISTAS SALVAS AQUI QUANDO REQUISITADO-->
		</div>
		
		<p class="p_fechar_menu">
			<a onclick="return fechar_elemento( 'div_abrir_lista' );">Cancelar</a>
		</p>
		
	</div>
	
	<!-- DIV MENU DE OPCOES, INCLUINDO "SAIR DA LISTA" -->
	<div id="div_menu">
		<h2>Menu</h2>
		<ul>
			<!-- FUNCAO NAO DEFINIDA -->
			<li>
				<a onclick="return fechar_elemento( 'div_menu' );">
					<img src="img/menu_gerenciar.png" align="absmiddle" />
				</a>
			</li>
			
			<!-- FUNCAO VER RECURSOS APLICADOS -->
			<li>
				<a onclick="javascript: carregar_recursos_aplicados( 'div_mostra_recursos_aplicados' ); abrir_elemento( 'div_ver_recursos' ); fechar_elemento_unico( 'div_menu' );">
					<img src="img/botao_ver_recursos.png" align="absmiddle" />
				</a>
			</li>
			
			<!-- FUNCAO ABRIR LISTAS SALVAS -->
			<li>
				<a onclick="javascript: carregar_listas_salvas( 'div_mostra_abrir_listas_salvas' ); abrir_elemento( 'div_abrir_lista' ); fechar_elemento_unico( 'div_menu' );">
					<img src="img/botao_abrir_lista.png" align="absmiddle" />
				</a>
			</li>
			
			<!-- FUNCAO NOVA LISTA -->
			<li>
				<a onclick="return alert( 'Nova Lista' );">
					<img src="img/botao_nova_lista.png" align="absmiddle" />
				</a>
			</li>
			
			<!-- FUNCAO PESQUISAR PRODUTO -->
			<li>
				<a onclick="javascript: abrir_elemento( 'div_pesquisar_produto' ); fechar_elemento( 'div_menu' ); exec_focus( 'input_pesquisar_produto' );">
					<img src="img/menu_pesquisar.png" align="absmiddle" />
				</a>
			</li>
			
			<!-- FUNCAO SAIR DA LISTA -->
			<li>
				<a onclick="return window.location = 'index.php';">
					<img src="img/menu_sair.png" align="absmiddle" />
				</a>
			</li>
		</ul>
		<p class="p_fechar_menu">
			<a onclick="return fechar_elemento( 'div_menu' );">Fechar Menu</a>
		</p>
	</div>

	<!-- DIV PARA EXIBIR MENSAGENS DE SUCESSO -->
	<div id="div_mensagens_sucesso">
		<div id="div_content_sucess"></div>
	</div>
	
	<!-- DIV PARA EXIBIR MENSAGENS DE ERRO -->
	<div id="div_mensagens_erro">
		<div id="div_content_erro"></div>
	</div>
	
	<!-- DIV FORMULARIO PARA PESQUISA DE PRODUTOS CADASTRADOS -->
	<div id="div_pesquisar_produto">
		
		<form method="POST" action="php/pesquisar_produto.php" onSubmit="return pesquisar_produto();">
			
			<h3>Pesquisar Item</h3>
			
			<p class="p_produto">
				Informe a palavra chave<br />
				<input class="input_text_divs" type="text" id="input_pesquisar_produto" value="" onkeyup="return formata_string( 'input_pesquisar_produto' );" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				<input class="input_button input_aplicar" type="submit" value="" />
				<input class="input_button input_fechar" type="reset" value="" onclick="return fechar_pesquisar_produto( 'div_pesquisar_produto' )" />
			</p>
			
		</form>
		
		<div id="div_mostrar_pesquisas">
			<!-- MOSTRA AQUI A LISTA DE PRODUTOS PESQUISADO PELA PALAVRA CHAVE -->
		</div>
		
	</div>
	
	<!-- DIV FORMULARIO PARA EDICAO DE PRODUTOS CADASTRADOS NA LISTA -->
	<div id="div_edita_produto">
		
		<form method="POST" action="php/alterar_produto.php" onSubmit="return alterar_produto();">
			
			<h3>Editar Item</h3>
			
			<p class="p_produto">
				Nome<br />
				<input class="input_text_divs" type="text" id="input_edita_produto" value="" onkeyup="return formata_string( 'input_edita_produto' );" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				Qtde<br />
				<input class="input_text_divs" type="text" id="input_edita_qtde" value="" onkeyup="return formata_decimal( 'input_edita_qtde' );" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				Pre&ccedil;o<br />
				<input type="text"   class="input_text_moeda" id="input_edita_preco" value="" onkeypress="return formata_moeda( this, '.', ',', event );" autocomplete="off" />
				<input type="button" class="input_button input_limpar" value="" onclick="return limpar_campo( 'input_edita_preco' )" />
			</p>
			
			<p class="p_produto">
				<input type="submit" class="input_button input_aplicar" value="" />
				<input type="reset"  class="input_button input_fechar"  value="" onclick="return fechar_elemento( 'div_edita_produto' )" />
				<input type="button" class="input_button input_remover" value="" onclick="return remover_produto()" />
				
				<input type="hidden" value="" id="input_hidden_edita_total" />
				<input type="hidden" value="" id="input_hidden_edita_item" />
			</p>
			
		</form>
	
	</div>
	
	<!-- DIV FORMULARIO PARA CRIACAO DE PRODUTOS NA LISTA -->
	<div id="div_cria_produto">
		
		<form method="POST" action="php/criar_produto.php" onSubmit="return criar_produto();">
			
			<h3>Novo Item</h3>
			
			<p class="p_produto">
				Nome<br />
				<input class="input_text_divs" type="text" id="input_cria_produto" value="" onkeyup="return formata_string( 'input_cria_produto' );" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				Qtde<br />
				<input class="input_text_divs" type="text" id="input_cria_qtde" value="" onkeyup="return formata_decimal( 'input_cria_qtde' );" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				Pre&ccedil;o<br />
			</p>
			
			<p class="p_produto">
				<input type="text"   class="input_text_moeda" id="input_cria_preco" value="" onkeypress="return formata_moeda( this, '.', ',', event );" autocomplete="off" />
				<input type="button" class="input_button input_limpar" value="" onclick="return limpar_campo( 'input_cria_preco' )" />
			</p>
			
			<p class="p_produto">
				<input type="submit" class="input_button input_aplicar" value="" />
				<input type="reset" class="input_button input_fechar"   value="" onclick="return fechar_elemento( 'div_cria_produto' )" />
			</p>
				
		</form>
		
	</div>
	
	<!-- DIV FORMULARIO PARA ADICIONAR RECURSOS NA LISTA -->
	<div id="div_aplica_dinheiro">
		
		<form method="POST" action="php/aplicar_dinheiro.php" onSubmit="return aplicar_dinheiro();">
				
			<h3>Adicionar Recurso</h3>
			
			<p class="p_produto">
				Identifica&ccedil;&atilde;o
				<br />
				<input type="text" id="input_id_novo_dinheiro" class="input_text_divs" onkeyup="return formata_string( 'input_id_novo_dinheiro' );" value="" autocomplete="off" />
			</p>
			
			<p class="p_produto">
				Valor
				<br />
				<input type="text"   class="input_text_moeda" id="input_novo_dinheiro" value="0,00" onkeypress="return formata_moeda( this, '.', ',', event );" autocomplete="off" />
				<input type="button" class="input_button input_limpar" value="" onclick="return limpar_campo( 'input_novo_dinheiro' )" />
			</p>
			
			<p>
				<input class="input_button input_aplicar" type="submit" value="" />
				<input class="input_button input_fechar" type="reset" value="" onclick="return fechar_elemento( 'div_aplica_dinheiro' )" />
			</p>
			
		</form>
			
	</div>
	
	<!-- DIV FORMULARIO PARA SALVAR LISTA COM NOVO NOME OU MESMO NOME -->
	<div id="div_salvar_lista">
		
		<form method="POST" action="php/salvar_lista.php" onSubmit="return salvar_lista();">
		
			<h2>Como deseja salvar a lista ?</h2>
			
			<p class="p_salvar_mesmo_nome">
				<input type="button" class="input_salvar_mesmo_nome" value="Salvar como <?php echo $nome_lista_ativa; ?> !" onclick="return salvar_lista( 'sobrescrever' )" />
			</p>
			
			<p class="p_salvar_novo_nome">
				Salvar como !
				<br />
				<input type="text"   class="input_text_divs" id="input_cria_nova_lista" value="" autocomplete="off" />
				
				<input type="button" class="input_button input_aplicar" name="" id="" value="" onclick="return salvar_lista( 'nova_lista' )" />
				<input type="reset"  class="input_button input_fechar" value="" id="" value="" onclick="return fechar_elemento( 'div_salvar_lista' )" />
			</p>
		
		</form>
		
	</div>
	
	<!-- FORMULARIO GERAL PARA GERENCIAR TODAS AS ACOES DO SISTEMA -->
	<form>
		
		<!-- DIV HEADER DA TABELA DO SISTEMA QUE CONTEM A LISTA ABERTA -->
		<div id="div_header_tabela_produtos">
			
			<table class="tabela_produtos">
				
				<thead>
					<tr>
						<th class="th_prod">Item</th>
						<th class="th_qtde">Qt</th>
						<th class="th_preco">Un</th>
						<th class="th_total">R$</th>
					</tr>
				</thead>
				
			</table>
			
		</div>
		
		<!-- DIV CONTEUDO REAL DA LISTA -->
		<div id="div_conteiner_lista">
		
		<!-- INSERE OS ITENS AQUI TANTO POR JAVASCRIPT QUANTO POR PHP -->
		
		<?php
		
			$nome_produto       = "";
			$qtde_produto       = "";
			$preco_produto      = "";
			$total_produto      = "";
			$indice_produto     = "";
			$total_compra       = "";
			$saldo_compra       = "";
			$qtde_itens         = "";
			$dinheiro_aplicado  = "";
			$guarda_recursos    = "";
			$contador           = 1;
			$index              = 0;
			$array_info_produto = array();
		
			$lista_ativa  = "listas/" . $nome_lista_ativa . ".xml";
			$array_xml    = simplexml_load_file( $lista_ativa );
			
			// Sorteando os valores para mostrar em ordem alfabetica
			if( count( $array_xml -> produto ) > 0 ) {
				
				foreach( $array_xml -> produto as $atributos ) {
					
					// Atributos e Parametros do XML em questao
					$nome_produto   = strtolower( $atributos -> nome_produto );
					$qtde_produto   = $atributos -> qtde_produto;
					$preco_produto  = $atributos -> preco_produto;
					$total_produto  = $atributos -> total_produto;
					$indice_produto = $atributos -> indice_produto;
					
					// Populando array para posterior ordenacao
					$array_info_produto[ $index ] = $nome_produto.':'.$qtde_produto.':'.$preco_produto.':'.$total_produto.':'.$contador;
					
					$contador += 1;
					$index    += 1;
					
				} sort( $array_info_produto );
				
			}
			
			// Mostrando os produtos sorteados em ordem alfabetica
			if( count( $array_info_produto ) > 0 ) {
				
				foreach( $array_info_produto as $info_produto ) {
					
					$tmp_explode     = explode( ":", $info_produto );
					$n_produto       = strtolower( $tmp_explode[0] ); // Nome produto
					$q_produto       = $tmp_explode[1];               // Qtde produto
					$p_produto       = $tmp_explode[2];               // Preco produto
					$t_produto       = $tmp_explode[3];               // Total produto
					$i_produto       = $tmp_explode[4];               // Contador produto
					$no_carrinho     = "nao";                         // Produto nao esta no "carrinho"
					$classe_dinamica = "prod_em_uso";                 // Classe gerenciada pelo javascript (cor verde)
					
					// Verifica e atualiza a classe do produto (cor vermelha)
					if( $t_produto == "0,00" || $t_produto == "" ) {
						
						$classe_dinamica = "prod_nao_usado";
						
					}
					
					// Montando o conteudo a ser visualizado na lista
					$conteudo_produto = '
						<div id="div_produto_'.$i_produto.'">
							<table class="tabela_produtos">
								<tr id="linha_produto_'.$i_produto.'">
									
									<td class="td_prod">
										<a id="nome_produto_'.$i_produto.'" class="a_altera_produto '.$classe_dinamica.'" onclick="return abrir_editor_produto( \''.$i_produto.'\' );">'.$n_produto.'</a>
									</td>
									
									<td class="td_qtde">
										<input type="button" id="qtde_produto_'.$i_produto.'" value="'.$q_produto.'" class="input_text '.$classe_dinamica.'" onclick="return item_no_carrinho( \''.$i_produto.'\' );" />
									</td>
									
									<td class="td_preco">
										<input type="button" id="preco_produto_'.$i_produto.'" value="'.$p_produto.'" class="input_text '.$classe_dinamica.'" onclick="return item_no_carrinho( \''.$i_produto.'\' );" />
									</td>
									
									<td class="td_total">
										<input type="button" id="total_produto_'.$i_produto.'" value="'.$t_produto.'" class="input_text '.$classe_dinamica.'" onclick="return item_no_carrinho( \''.$i_produto.'\' );" />
										
										<input type="hidden" id="info_produto_'.$i_produto.'" name="info_produto" value="'.$info_produto.'" />
										<input type="hidden" id="indice_no_carrinho_'.$i_produto.'" name="indice_no_carrinho" value="'.$i_produto.'" />
										<input type="hidden" id="no_carrinho_'.$i_produto.'" name="no_carrinho" value="'.$no_carrinho.'" />
									</td>
									
								</tr>
							</table>
						</div>';
					
					echo $conteudo_produto;
					
				}
			
			}
			
			// Tratando da parte de saldos e recursos da lista atual
			
			/* SALDOS */
			foreach( $array_xml -> saldos as $valores ) {
				
				$total_compra      = $valores -> total_compra;
				$saldo_compra      = $valores -> saldo_compra;
				$qtde_itens        = $valores -> qtde_itens;
				$dinheiro_aplicado = $valores -> dinheiro_aplicado;
				$guardar_contador  = $valores -> contador;
			
			}
			
			// Formatando qtde de itens para mostrar na tela do sistema
			$qtde_itens_visual = "";
			
			if($qtde_itens == "Nenhum Item" || $qtde_itens == 0) {
				
				$qtde_itens        = 0;
				$qtde_itens_visual = "Nenhum Item";
				
			}
			
			if($qtde_itens == 1) {
				
				$qtde_itens_visual = $qtde_itens . " Item";
				
			}
			
			if($qtde_itens > 1) {
				
				$qtde_itens_visual = $qtde_itens . " Itens";
				
			}
			
			/* RECURSOS */
			foreach( $array_xml -> recurso as $sub_recurso ) {
				
				$nome_recurso  = $sub_recurso -> nome;
				$valor_recurso = $sub_recurso -> valor;
				
				if( $nome_recurso <> "" and $valor_recurso <> "" ) {
					
					$guarda_recursos .= $nome_recurso.":".$valor_recurso.";";
					
				}
			
			}
		
		?>
		
		</div>
		
		<!-- DIV INFO SOBRE A LISTA ABERTA -->
		<div id="div_info_lista">
			<p>
			<?php
				echo str_replace("_", " ", $nome_lista_ativa);
			?>
			</p>
		</div>
		
		<!-- DIV DE CONTROLES E MENU -->
		<div id="div_controle_lista">
			
			<!-- DIV BOTAO ADICIONAR RECURSOS -->
			<div id="div_botao_aplica_dinheiro">
			
				<input type="button" id="input_botao_aplica_dinheiro" onclick="javascript: abrir_elemento( 'div_aplica_dinheiro' ); exec_focus( 'input_id_novo_dinheiro' );" value="" />
			
			</div>
			
			<!-- DIV BOTAO ADICIONAR ITEM -->
			<div id="div_botao_mais_itens">
				
				<input type="button" id="input_botao_mais_itens" onclick="javascript: abrir_elemento( 'div_cria_produto' ); exec_focus( 'input_cria_produto' );" value="" />
				
			</div>
			
			<!-- DIV BOTAO SALVAR -->
			<div id="div_botao_salvar">
				
				<input type="button" id="input_botao_salvar" name="input_botao_salvar"  onclick="javascript: abrir_elemento( 'div_salvar_lista' ); exec_focus( 'input_cria_nova_lista' );" value="" />
			
			</div>
			
			<!-- DIV BOTAO MENU DE OPERACOES EXTENDIDO -->
			<div id="div_botao_menu">
			
				<input type="button" id="input_botao_menu" onclick="return abrir_elemento( 'div_menu' );" value="" />
				
			</div>
			
		</div>
		
		<!-- DIV INFO SOBRE QTDE DE ITENS E SALDO EM TEMPO REAL -->
		<div id="div_status_compra">
		
			<div id="div_qtde_itens">
			<?php
			
			echo '<p>
					<span id="span_qtde_itens">'.$qtde_itens_visual.'</span>
					<input type="hidden" name="input_hidden_qtde_itens" id="input_hidden_qtde_itens" value="'.$qtde_itens.'" />
				</p>';
			
			?>
			</div>
			
			<div id="div_saldo_compra">
			<?php
			
			echo '<p>
					Saldo R$ 
					<input type="text" id="input_saldo_compra" value="'.$saldo_compra.'" disabled />
				</p>';
					
			?>
			</div>
			
		</div>
		
		<!-- DIV INFO RECURSOS E TOTAL DE GASTOS EM TEMPO REAL -->
		<div id="div_rodape">
			
			<div id="div_dinheiro_aplicado">
			
			<?php
			
			echo '<p>
					Recurso Total<br />
					R$ <input type="text" id="input_dinheiro_compra" value="'.$dinheiro_aplicado.'" disabled />
				</p>';
					
			?>
			</div>
			
			<div id="div_total_compra">
			<?php
			
			echo '<p>
					Custo Total<br />
					R$ <input type="text" id="input_total_compra" value="'.$total_compra.'" disabled />
				</p>';
					
			?>
			</div>
			
		</div>

	<?php
		
	// Input ocultos com valores importantes ao sistema
	echo '
		<input type="hidden" name="input_hidden_nome_lista"      id="input_hidden_nome_lista"      value="'.$nome_lista_ativa.'" />
		
		<input type="hidden" name="input_hidden_guarda_contador" id="input_hidden_guarda_contador" value="'.$contador.'" />
		
		<input type="hidden" name="input_hidden_guarda_recursos" id="input_hidden_guarda_recursos" value="'.$guarda_recursos.'" />
		
		';
		
	?>
				
	</form>
	
</div>

<script src="js/vars.js" type="text/javascript"></script>
<script src="js/shared.js" type="text/javascript"></script>

<script src="js/acessar_lista_salva.js" type="text/javascript"></script>
<script src="js/carregar_listas_salvas.js" type="text/javascript"></script>
<script src="js/carregar_recursos_aplicados.js" type="text/javascript"></script>
<script src="js/criar_nova_lista.js" type="text/javascript"></script>
<script src="js/excluir_confirmado.js" type="text/javascript"></script>
<script src="js/excluir_recurso_confirmado.js" type="text/javascript"></script>
<script src="js/lista_ja_existe.js" type="text/javascript"></script>

<script src="js/salvar_lista.js" type="text/javascript"></script>
<script src="js/salvar_lista_auto.js" type="text/javascript"></script>
<script src="js/aplicar_dinheiro.js" type="text/javascript"></script>
<script src="js/remover_produto.js" type="text/javascript"></script>
<script src="js/alterar_produto.js" type="text/javascript"></script>
<script src="js/criar_produto.js" type="text/javascript"></script>
<script src="js/pesquisar_produto.js" type="text/javascript"></script>

<script src="js/jquery.js" type="text/javascript"></script>

<script>
	window.onload = function() { verificar_saldo_atual(); }
</script>

</body>
</html>
