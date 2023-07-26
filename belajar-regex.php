<?php 
// https://www.youtube.com/watch?v=qnwHDX3p0Vo&list=TLPQMjYwNzIwMjNoI2l5D0nqzw&index=1&pp=gAQBiAQB



// flags g (global ) fungsinya untuk membaca semua yang ada di regex ini karna kalau tidak maka hanya akan mengembalikan ilai Arman
// tapi karna ini php jadi jangan gunakan g cuku ganti preg_match dengan preg_match_all()
// flag i fungsinya agar tidak peduli lower atau uppercase
// . adalah karakter pengganti dan hanya menginterpretasikan 1 char saya per titik nya shingga jika ingin mengambil karakter 2 biji maka gunakan dua titik ..
$regex = "/Arm.. |Mahasiswa/i";
$exString = "Arman Adalah Mahasiswa UNIKOM";

preg_match_all($regex, $exString, $matchesString);
var_dump($matchesString);

// kelas karakter
$string2 = "bag-big-bug-beg- ** *";
$regex2 = "/b[aiu]g/";
$regexOperator = "/[]/";
$myRegex = "/-(.*?)-/";


$string3 = "cat-bat-dat-eat";
$regex3 = "/[b-e]at/";
preg_match_all($regex3, $string3, $matchBug);

var_dump($matchBug);
// [0-9]at untuk angka artinya akan mengambil seluruh data di interval 0 sampai 9 


// REGEX NEGATIf
echo "REGEX NEGATIF";
$string4 = "aiueo-sasisuseso-mmghs";
$regex4 = "/[^aiueo]/";
// $regex5 = "** s";
preg_match_all($regex4, $string4, $match);
var_dump($match);

// karakter berturut
$string5 = "sssssssssssssaaaaaaaaaaa"; 
$string51 = "gooogggle";
$regex5 = "/s*/";
$regex51 = "/go*/";

preg_match_all($regex5, $string5, $match);
var_dump($match);

// shortcut
$string6 = "asd123980asdn,**samd";
$regex6 = "/[A-Za-z0-9]/"; // atau /[A-Za-z0-9_]/
// shortcut
$regex61 = "/\w/"; // untuk mengambil string, shortcutnya adapun negatif dari \w adalah \W
$regex62 = "/\d/"; // untuk angka, \D untuk tidak menselect angka

preg_match_all($regex62, $string6, $match);
var_dump($match);

// string berdasarkan pola

$string7 = "armaaaaaaaan";
$regex7 = "/arma{5,10}n/"; // , artinya bisa lebih dari 5, tapi minimal 5. 10 artinya kurang dari 10
preg_match_all($regex7, $string7, $match);
var_dump($match);


// nama pengguna dapat menggunakan alfanumerik
// satu satunya nomor dinama pengguna harus diakhir
// nama pengguna bisa upper/lowercase
// nama pengguna tidak boleh kurang dari 2 karakter

$string8 = "aaasd";
$regex8 = "/^[a-z][a-z]+\d*$|^[a-z]\d\d+$/";
preg_match_all($regex8, $string8, $match);
var_dump($match);


// coba regex
$stringCoba = "fu(nction getNama(){ return this.nama };";
$regexCoba = "/(function)/";
preg_match_all($regexCoba, $stringCoba, $match);
var_dump($match);



 ?>