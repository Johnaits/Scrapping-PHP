<?php

$code = file_get_contents("https://www.gov.br/esocial/pt-br/documentacao-tecnica/manuais/leiautes-esocial-v-1-1-beta/tabelas.html");

$code = str_replace(">", "<", $code);
$splitCode = explode("<", $code);

// ENCONTRA PRIMEIRA OCORRENCIA DA TABELA
$openingTag = array_search('table id="18" class="table is-fullwidth is-bordered tabela quebra-anterior"', $splitCode, true);

// ENCONTRA ULTIMA OCORRENCIA DA TABELA
$closingTag = array_search('table id="19" class="table is-fullwidth is-bordered tabela quebra-anterior"', $splitCode, true);


//INICIO DA VARREDURA E VARIAVEIS DO JSON
$i = $openingTag+1;
$datatitle = array();
$datatext = array();
$alldata = array();


while ($i < $closingTag) {
	
	//IDENTIFICA TITULO
	if(str_contains($splitCode[$i],"td style")){
		$i++;
		$datatitle[] = $splitCode[$i];
		
	}

	//IDENTIFICA TEXTO-DADO
	if(str_contains($splitCode[$i],"td")){
		$i++;
		
		$splitCode[$i] = trim($splitCode[$i]);
		if($splitCode[$i]==""){
			null;
		}
		else{
			$datatext[] = $splitCode[$i];

		}
	}
	$i++;
}

//PERCORRE OS OBJECTS E DEFINE EM UM SÓ
for($j=0;$j<count($datatext);){
for($i=0;$i<count($datatitle);$i++){
	$alldata[$datatitle[$i]] = $datatext[$j];
	$j++;
}
$data[$j]=$alldata;
}

//PRINTA O JSON
print_r(json_encode($data, JSON_UNESCAPED_UNICODE));



?>