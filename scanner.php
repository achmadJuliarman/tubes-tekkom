<?php 
$myfile = file_get_contents('myFile.js');
$t_delimiter = [];
$t_keyword = [];
$t_operator = [];
$t_name = [];
$t_nilai_konstanta = [];

// $str = 'before-str-after';
// if (preg_match('/-(.*?)-/', $str, $match) == 1) {
//     var_dump($match);
// }

// PERIKSA DELIMITER 
echo $myfile;
$chars = $myfile;
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
$myfile = str_replace(array("\n", "\t", "{", "}"), " ", $myfile); // untuk hapus enter agar symbol di line baru terbaca
$words = explode(" ",$myfile);
// var_dump($myfile);
$k = 0;
echo "<br>";
while($k < count($words))
{
	if (in_array($words[$k], $keyword)) {
		array_push($t_keyword, $words[$k]); // memasukkan keyword ke token
		if ($words[$k] === 'const' || $words[$k] === 'var' || $words[$k] === 'let') 
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

// PERIKSA NILAI KONSTANTA
// periksa perhuruf trus kalau gak ketemu ' ' concat string
$nk = 0;
$nilai_k = "";
$konstanta = str_replace('"', "--", $myfile);
$konstanta = str_replace("'", "--", $konstanta);
preg_match_all('/--(.*?)--/', $konstanta, $kons);

for ($i=0; $i < count($kons[1]); $i++) { 
	array_push($t_nilai_konstanta, $kons[1][$i]);
}


echo '<br><br>TOKEN DELIMITER';
var_dump($t_delimiter);
echo 'TOKEN OPERATOR';
var_dump($t_operator);
echo 'TOKEN NAME';
var_dump($t_name);
echo 'TOKEN KEYWORD';
var_dump($t_keyword);
echo 'TOKEN NILAI KONSTANTA';
var_dump($t_nilai_konstanta);

function getTokens($delimiter, $name, $keyword, $operator, $konstanta)
{
	$tokens['delimiter'] = $delimiter;
	$tokens['keyword'] = $name;
	$tokens['name'] = $keyword;
	$tokens['operator'] = $operator;
	$tokens['nilai_konstanta'] = $konstanta;

	return $tokens;
}

echo "<br><br><br>KUMPULAN TOKENS";
var_dump(getTokens($t_delimiter, $t_name, $t_keyword, $t_operator, $t_nilai_konstanta));

 ?>