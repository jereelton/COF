<?php

session_start();

if( isset( $_POST[ 'acessar_lista_salva' ] ) ) {
	
	$nome_lista = trim( $_POST[ 'acessar_lista_salva' ] );
	$resposta   = "";
		
	$_SESSION[ 'nome_lista' ] = $nome_lista;
	
	if( isset( $_SESSION[ 'nome_lista' ] ) ) {
		
		$resposta = "sucesso";
		
	} else {
		
		$resposta = "falhou";
		
		}
	
	echo $resposta;

} else {
	
	die( "Erro na passagem dos parametros : _POST" );
	
	}

?>
