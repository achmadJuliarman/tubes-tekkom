<?php 
$myfile = file_get_contents('myFile.js');
$myfile = preg_replace("/\/\/.*/", " ", $myfile); // hapus single comment
$myfile = preg_replace("/\/\*.*?\*\//s", " ", $myfile); // hapus multiline comment
$keywordRegex = 
"/((?<=[^A-z0-9])function(?=[^A-z0-9])|(?<=[^A-z0-9])if(?=[^A-z0-9])|(?<=[^A-z0-9])else(?=[^A-z0-9])|(?<=[^A-z0-9])return(?=[^A-z0-9])|(?<=[^A-z0-9])var(?=[^A-z0-9])|(?<=[^A-z0-9])let(?=[^A-z0-9])|(?<=[^A-z0-9])const(?=[^A-z0-9])|(?<=[^A-z0-9])for(?=[^A-z0-9])|(?<=[^A-z0-9])while(?=[^A-z0-9])|(?<=[^A-z0-9])switch(?=[^A-z0-9])|(?<=[^A-z0-9])case(?=[^A-z0-9])|(?<=[^A-z0-9])break(?=[^A-z0-9])|(?<=[^A-z0-9])continue(?=[^A-z0-9])|(?<=[^A-z0-9])do(?=[^A-z0-9])|(?<=[^A-z0-9])default(?=[^A-z0-9])|(?<=[^A-z0-9])class(?=[^A-z0-9])|(?<=[^A-z0-9])new(?=[^A-z0-9])|(?<=[^A-z0-9])this(?=[^A-z0-9])|(?<=[^A-z0-9])typeof(?=[^A-z0-9])|(?<=[^A-z0-9])instanceof(?=[^A-z0-9])|(?<=[^A-z0-9])import(?=[^A-z0-9])|(?<=[^A-z0-9])export(?=[^A-z0-9])|(?<=[^A-z0-9])static(?=[^A-z0-9]))/";
var_dump($myfile);
$delimiterRegex = "/[\(\){}\[\];,.]/";
$valueRegexNumber = "/(?<=\s|^\s)[0-9]*(?=\;)/m";
$valueRegexString = "/(?<=\")(.*?)(?=\")/";

$tokens = [];
preg_match_all($keywordRegex, $myfile, $t_keyword);
array_push($tokens, $t_keyword[0]);

preg_match_all($delimiterRegex, $myfile, $t_delimiter);
array_push($tokens, $t_delimiter[0]);

preg_match_all($valueRegexNumber, $myfile, $t_value_number);
array_push($tokens, $t_value_number[0]);

preg_match_all($valueRegexString, $myfile, $t_value_string);
array_push($tokens, $t_value_string[0]);

var_dump($tokens);




 ?>