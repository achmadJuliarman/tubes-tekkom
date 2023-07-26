<?php 
// REFERENSI REGEX 1
// https://www.youtube.com/watch?v=gXvaQAl5pWc&list=TLPQMjYwNzIwMjNoI2l5D0nqzw&index=2

$s = "bla456bla";
$r = "/[0-9][0-9][0-9]/";

$s = "the color is gray";
$r = "/gr[ae]y/";

$s = "bla3Bla";
$r = "/[A-z][0-9][A-z]/";  // A-z artinya dari huruf lower-upeer termasuk

// negasi
$s = "bla!!a";
$r = "/[^A-z0-9][^A-z0-9][A-z0-9]/";

// metacharacter . dot
$s = "bla!!2aa";
$r = "/.[0-9]../";

// Matching really the caracter
$s = "bla!!2..aa.";
$r = "/.\./";

// desimal digit character
$s = "bla!!232..aa.";
$r = "/\d\d\d/";

// ALFANUMERIK, shoorthand [a-zA-Z0-9_]
$s = "@93 CbA_ ikkkp";
$r = "/\w\w\w\w/";

// WHITESPACE
$s = "@93 CbA_ ikkkp";
$r = "/\s/";

// START OF STRING, DIA BERBEDA DENGAN LINE 16 
// karana regexnya ^[A-z] maka hasilnya hanya mengambil karakter pertama saja
$s = "indonesia raya";
// $s = "1ndonesia raya";
$r = "/^[A-z]/";
// $r = "/^[A-z][A-z]/";


// END OF STRING $ 
$s = "17089 Indonesia Raya 167aa";
$r = "/[A-z][A-z]$/";
// ----- coba end of string
$s = "let umur = 20 ;";
$r = "/^(=)(;)$/"; // gagal teuing kunaon can ngarti

// latihan ambil karakter yang di himpit ' atau "
// $s = 'let nama = "Achmad Juliarman";';
$s = "let nama ='Achmad Juliarman';";
$r = "/(?<=\'|\").*(?=\'|\";)/";


// REGEX ZERO OR MORE
$s = "ct"; // kenapa ct juga masuk karena 'zero' or more 
$s1 = "cat";
$s2 = "caaaaaat";
$r = "/ca*t/";


// REGEX ONE OR MORE
$s = "ct"; 
$s1 = "cat";
$s2 = "caaaaaat";
$r = "/ca+t/";

// REGEX ZERO OR ONE
$s = "color"; // kenapa ct juga masuk karena 'zero' or more 
$s1 = "colour";
$s2 = "colouuur";
$r = "/colou?r/";

// REGEX QUANTIFIER {m, n} or{m}
$s = "color"; // kenapa ct juga masuk karena 'zero' or more 
$s1 = "colooor";
$s2 = "coloor";
$r = "/colo{2,4}r/";
// $r = "/colo{2,}r/"; // 2 atau lebih
// $r = "/colo{2}r/"; // hanya match s2


// REGEX GROUPING () =====> cat+ vs (cat)+
// kalau pake kurung artinya yang dihitung jumlahnya adalah yang dikurungin entak itu 1 char atau terdiri dari banyak char
// (cat)+ dari cattt hasilnya cat saja kalau cat+ => cattt
// sedangkan tanpa kurung cat+ artinya yang dihitung t nya saja

$s1 = "cattt";
$s2 = "catcatcat";
$r = "/cat+/"; // ini terlihat kalau kita pake preg_match() 'pas di s2'
$r2 = "/(cat)+/";
// preg_match($r, $s2, $m); 

// REGEX GROUPING PASAL 2
$s1 = "Feb 2022";
$s2 = "February 2022";
$s3 = "Feby 2022";
$r = "/Feb(ruary)? 2022/";

// SEARCH FOR ALL NON-OVERLAPPING MATCHES OF PATTERN 
$s = "In 1908, Budi Utomo Was Formed. The Youth Pledge Was Declared in 1928.
indonesia declared independence in 1945";
$r = "/\d{4}/";
echo preg_replace('/\d{4}/', 'Year', $s);

// preg_match_all($r, $s, $m); 
// var_dump($m);


// =================================
// REFERENSI REGEX 2
// https://youtu.be/rhzKDrUiJVk?list=TLPQMjYwNzIwMjNoI2l5D0nqzw

// REGEX ADALAH CARA UNTUK MENCARI STRING DALAM TEXT
// cause in PHP we don't need /g to search in global, we just use preg_match_all() instead of /g
echo "<br><br><br><br>================================================================================";
echo "<br><br><B>TUTORIAL 2</B>";
$s = "The fat cat run down the street.
It was searching for mouse to eat.";
echo "<br>".$s;
$s1 = $myfile = file_get_contents('myFile.js');

$r = "/re*/"; // it means 0 or more, kalau tidak ada e pun tetap ambil karakternya

$r = "/./"; // get anything except new line

$r = "/\./"; // search a dot, '.' anything except a new line, \ to cancel out anything after, so \. anything white dot

$r = "/\w/"; // match any word caracter, but the retun is a char not a word but ignore whitespace, \W is negasi for \w

$r = "/\s/"; // whitespace \S is negasi for \s

$r = "/\w{4}/"; // all the word that 4 char long but {4,} it means 4 digit or more

// GET ALL CARACTER INSIDE THE GROUP
$r = "/[fc]at/"; // get any word that start with f or c and end with at

$r = "/(t|T)he/"; // so it's prove that $array[0] is the right one 

$r = "/(t|e|r){2,3}/";

$r = "/(t|e|r){2,3}\./"; // and {2,3} is must exact the char in group so 'eat.' not selected

$r = "/^T/";	// match the beginiing the whole text

$r = "/^I/m";	// match the beginning multiline

$r = "/\.$/"; // match of the end of the statement

// look behind
// we'll got every single word that preceded inside group
$r = "/(?<=[t|T]he)/"; //matches the group before the main expres without including it in result; so we got whitespace
// harusnya ini cuman 2 sih

$s = "let umur = 20";
$r = "/(?<=\=\s)./";
preg_match_all($r, $s, $m);
var_dump($m);


 ?>