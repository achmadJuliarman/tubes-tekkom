<?php 
$myfile = file_get_contents('myFile.js');
$t_delimiter = [];
$t_keyword = [];
$t_operator = [];
$t_name = [];
$t_nilai_konstanta = [];
$tokens = [];




// PERIKSA DELIMITER 
echo $myfile;
$chars = strval($myfile);
$i = 0;
$delimiter = [';', '(', ')'];
while($i < strlen($chars))
{
	$char = $myfile[$i];
	if (in_array($char, $delimiter)) {
		array_push($t_delimiter, $char); // memasukkan ke token delimiter
	}
	$i++;
}


// PERIKSA KEYWORD DAN NAMA VARIABEL
$keyword = ['const', 'var', 'let', 'if', 'else', 'function', 'length', 'return'];
$myfile = str_replace(array("\n"), ' ', $myfile); // untuk hapus enter agar symbol di line baru terbaca
$words = explode(" ",$myfile);
// var_dump($myfile);
$k = 0;
while($k < count($words))
{
	$word = $words[$k];
	if (in_array($word, $keyword)) {
		array_push($t_keyword, $word); // memasukkan keyword ke token
		if ($word === 'const' || $word === 'var' || $word === 'let') 
		{
			array_push($t_name, $words[$k+1]); // memasukan nama variabel ke token name
		}
	}
	$k++;
}

// PERIKSA OPERATOR
$o = 0;
$operator = ['=', '==', '===', '*', '**', '/', '%', '+', '-', '<', '>', '<=', '>='];
while($o < strlen($chars))
{
	if(in_array($myfile[$o], $operator))
	{
		// cek operator '=' '==' '==='
		if ($myfile[$o] === '=') 
		{
			if($myfile[$o+1] === '=')
			{
				if ($myfile[$o+2] === '=') 
				{
					$ope = $myfile[$o] . $myfile[$o+1] . $myfile[$o+2];
					array_push($t_operator, $ope);
				}else{
					$ope = $myfile[$o] . $myfile[$o+1];
					array_push($t_operator, $ope);
				}
			}else{
				array_push($t_operator, $myfile[$o]);
			}
		}

		// cek operator '*' '**'
		if ($myfile[$o] === '*')
		{
			if($myfile[$o+1] === '*')
			{
				$ope = $myfile[$o] . $myfile[$o+1];
				array_push($t_operator, $ope);
			}else{
				array_push($t_operator, $myfile[$o]);
			}
		}

		// cek operator '<' '<='
		if($myfile[$o] === '<'){
			if($myfile[$o+1] === '='){
				$ope = $myfile[$o] . $myfile[$o+1];
				array_push($t_operator, $ope);
			}else{
				array_push($t_operator, $myfile[$o]);
			}
		}

		// cek operator '>' '>='
		if($myfile[$o] === '>'){
			if($myfile[$o+1] === '='){
				$ope = $myfile[$o] . $myfile[$o+1];
				array_push($t_operator, $ope);
			}else{
				array_push($t_operator, $myfile[$o]);
			}
		}

	}
	$o++;
}
echo '<br><br>TOKEN DELIMITER';
var_dump($t_delimiter);
echo 'TOKEN OPERATOR';
var_dump($t_operator);
echo 'TOKEN NAME';
var_dump($t_name);
echo 'TOKEN KEYWORD';
var_dump($t_keyword);

function getTokens($delimiter, $name, $keyword)
{
	
	$tokens = array();
	array_push($tokens, $delimiter);
	array_push($tokens, $name);
	array_push($tokens, $keyword);
	return $tokens;
}

echo "<br><br><br>KUMPULAN TOKENS";
var_dump(getTokens($t_delimiter, $t_name, $t_keyword));

 ?>