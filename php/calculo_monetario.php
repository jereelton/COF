<?php

# Obrigado PHP Brasil: criado por Claudio Diniz em 30/04/2002 3:26pm
# Use: formataReais("347,89", "67,12", "+");

function calcular_operacao_monetaria( $valor1, $valor2, $operacao ) {
	
	/*
	 * function formataReais ($valor1, $valor2, $operacao)
	 * $valor1 = Primeiro valor da operação
	 * $valor2 = Segundo valor da operação
	 * $operacao = Tipo de operações possíveis . Pode ser :
		* "+" = adição,
		* "-" = subtração,
		* "*" = multiplicação
	*
	*/
	
	// Antes de tudo , arrancamos os "," e os "." dos dois valores passados a função.
	// Para isso , podemos usar str_replace :
	$valor1 = str_replace ( ",", "", $valor1 );
	$valor1 = str_replace ( ".", "", $valor1 );
	
	$valor2 = str_replace ( ",", "", $valor2 );
	$valor2 = str_replace ( ".", "", $valor2 );
	
	// Agora vamos usar um switch para determinar qual o tipo de operação que foi definida :
	switch ($operacao) {
		
		// Adição :
		case "+":
			$resultado = $valor1 + $valor2;
			break;
		
		// Subtração :
		case "-":
			$resultado = $valor1 - $valor2;
			break;
		
		// Multiplicação :
		case "*":
			$resultado = $valor1 * $valor2;
			break;
		
	} // Fim Switch
	
	// Calcula o tamanho do resultado com strlen
	$len = strlen ($resultado);
	
	$retorna = "";
	
	// Novamente um switch , dessa vez de acordo com o tamanho do resultado da operação ($len) :
	// De acordo com o tamanho de $len , realizamos uma ação para dividir o resultado e colocar
	// as vírgulas e os pontos
	switch ($len) {
		
		// 2 : 0,99 centavos
		case "2":
			$retorna = "0,$resultado";
			break;
		
		// 3 : 9,99 reais
		case "3":
			$d1 = substr("$resultado",0,1);
			$d2 = substr("$resultado",-2,2);
			$retorna = "$d1,$d2";
			break;
		
		// 4 : 99,99 reais
		case "4":
			$d1 = substr("$resultado",0,2);
			$d2 = substr("$resultado",-2,2);
			$retorna = "$d1,$d2";
			break;
		
		// 5 : 999,99 reais
		case "5":
			$d1 = substr("$resultado",0,3);
			$d2 = substr("$resultado",-2,2);
			$retorna = "$d1,$d2";
			break;
		
		// 6 : 9.999,99 reais
		case "6":
			$d1 = substr("$resultado",1,3);
			$d2 = substr("$resultado",-2,2);
			$d3 = substr("$resultado",0,1);
			$retorna = "$d3.$d1,$d2";
			break;
		
		// 7 : 99.999,99 reais
		case "7":
			$d1 = substr("$resultado",2,3);
			$d2 = substr("$resultado",-2,2);
			$d3 = substr("$resultado",0,2);
			$retorna = "$d3.$d1,$d2";
			break;
		
		// 8 : 999.999,99 reais
		case "8":
			$d1 = substr("$resultado",3,3);
			$d2 = substr("$resultado",-2,2);
			$d3 = substr("$resultado",0,3);
			$retorna = "$d3.$d1,$d2";
			break;
	
	} // Fim Switch
	
	// Por fim , retorna o resultado já formatado
	return $retorna;
	
} // Fim da function


?>
