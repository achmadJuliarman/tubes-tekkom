<?php 
$myfile = file_get_contents('myFile.js');
$myfile = preg_replace("/\/\/.*/", " ", $myfile); // hapus single comment
$myfile = preg_replace("/\/\*.*?\*\//s", " ", $myfile); // hapus multiline comment
$myfile = preg_replace("/(?<=\=)(?=[^=])/s", " ", $myfile); // tambah \s jika setelah = tidak ada spasi
$myfile = preg_replace("/(?<=\=)\s*(?=[^=])/s", " ", $myfile); // ubah multi \s dengan single \s
$myfile = preg_replace("/(?<=)\s*(?=\;)/s", "", $myfile); // hapus \s sebelum semicolon
var_dump($myfile);

$keywordRegex = 
"/(?<=[^A-Za-z0-9])(function|if|else|return|var|let|const|for|while|switch|case|break|continue|do|default|class|new|this|typeof|instanceof|import|export|static)(?=[^A-Za-z0-9])/";
$delimiterRegex = "/[\(\)\{\}\[\];,.]/";
$valueRegexNumber = "/(?<=\s)[0-9]*[ -|-]?[0-9]*?(?=\;)/m";
$valueRegexString = "/(?<=\"|\')(.*?)(?=\"\;|\'\;)/";
// $operatorRegex = "/\?[\:\=\!\|\&]|[\&\|\^~\<\>\+\-\*\/%]?\=?\=|\>\>|\>\>\>|\+\+|\-\-|\&\&\=|\|\|\=|\?\?=/";
$operatorRegex = "/(?<=\s|[A-z0-9])==|!=|=|\*\*|\*|\/|\+=|\+\+|\+|-=|--|-|%|\|\||\||&&|&=|&|\<\<=|\<=|\<|\>\>=|\>=|\>(?=[\s|^\s]|[A-z0-9])/";

$tokens = [];
preg_match_all($keywordRegex, $myfile, $t_keyword); 
array_push($tokens, $t_keyword[0]);

preg_match_all($delimiterRegex, $myfile, $t_delimiter);
array_push($tokens, $t_delimiter[0]);

preg_match_all($valueRegexNumber, $myfile, $t_value_number);
array_push($tokens, $t_value_number[0]);

preg_match_all($valueRegexString, $myfile, $t_value_string);
array_push($tokens, $t_value_string[0]);

preg_match_all($operatorRegex, $myfile, $t_operator);
array_push($tokens, $t_operator[0]);
  

function getTokens(){
    global $tokens;
    return $tokens;
}
var_dump(getTokens());



 ?>