<?php 
if (isset($_POST['js-code'])) {
  $myfile = $_POST['js-code'];
}else{
  $myfile = "";
}

$myfile = preg_replace("/\/\/.*/", " ", $myfile); // hapus single comment
$myfile = preg_replace("/\/\*.*?\*\//s", " ", $myfile); // hapus multiline comment
$myfile = preg_replace("/(?<=\=)(?=[^=])/s", " ", $myfile); // tambah \s jika setelah = tidak ada spasi, untuk variabel
$myfile = preg_replace("/(?<=[A-z0-9])(?==)/s", " ", $myfile); // tambah \s jika sebelum = tidak ada spasi, untuk variabel
$myfile = preg_replace("/(?<=\=)\s*(?=[^=])/s", " ", $myfile); // ubah multi \s dengan single \s
$myfile = preg_replace("/(?<=)\s*(?=\;)/s", "", $myfile); // hapus \s sebelum semicolon

// (?<=[^A-Za-z0-9]) bermakna ambil semua simbol/karakter(function|if|else dll) 
// yang bukan (^) diawalli dengan huruf A-z, a-z, dan 0-9 
$keywordRegex = 
"/(?<=[^A-Za-z0-9])(function|if|else|return|var|let|const|for|while|switch|case|break|continue|do|default|class|new|this|typeof|instanceof|import|export|static)(?=[^A-Za-z0-9])/";

// ambil seluruh simbol yang terdiri (, ), {, }, [, ], ;, ',', .
$delimiterRegex = "/[\(\)\{\}\[\];,.]/";
$operatorRegex = "/(?<=\s|[A-z0-9])==|!=|=|\*\*|\*|\/|\+=|\+\+|\+|-=|--|-|%|\|\||\||&&|&=|&|\<\<=|\<=|\<|\>\>=|\>=|\>(?=[\s|^\s]|[A-z0-9])/";

// ambil seluruh angka [0-9] 
$valueRegexNumber = "/(?<=\s)-?\s*[0-9]*\.*[0-9]*(\s*-\s*|\s*\+\s*|\s*\/\s*|\s*\%\s*)?[0-9]*\.*[0-9]*(?=\;)/m";
$valueRegexString = "/(?<=\"|\')(.*?)(?=\"\;|\'\;)/";
$valueRegexArray = "/(?<=\s)\[(.*?)\](?=\;)/";

//
$variabelRegex = "/(?<=var|let|const|[,|\s,])\w+(?=\s=|\s,|,)/";
$namaFungsiRegex = "/(?<=function\s).*(?=\s*\(\))/"; 

$tokens = [
  "keyword" => [],
  "delimiter" => [],
  "value_number" => [],
  "value_string" => [],
  "value_array" => [],
  "nama_fungsi" => [],
  "operator" => [],
  "variabel" => []
];
preg_match_all($keywordRegex, $myfile, $t_keyword); 
array_push($tokens['keyword'], $t_keyword[0]);

preg_match_all($delimiterRegex, $myfile, $t_delimiter);
array_push($tokens['delimiter'], $t_delimiter[0]);

preg_match_all($valueRegexNumber, $myfile, $t_value_number);
array_push($tokens['value_number'], $t_value_number[0]);

preg_match_all($valueRegexString, $myfile, $t_value_string);
array_push($tokens['value_string'], $t_value_string[0]);

preg_match_all($valueRegexArray, $myfile, $t_value_array);
array_push($tokens['value_array'], $t_value_array[0]);

preg_match_all($operatorRegex, $myfile, $t_operator);
array_push($tokens['operator'], $t_operator[0]);

preg_match_all($variabelRegex, $myfile, $t_variabel);
array_push($tokens['variabel'], $t_variabel[0]);

preg_match_all($namaFungsiRegex, $myfile, $t_nama_fungsi);
array_push($tokens['nama_fungsi'], $t_nama_fungsi[0]);

function getTokens(){
    global $tokens;
    return $tokens;
}

// var_dump(getTokens());

 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <style>
    textarea {
      width: 100%;
      height: 500px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-family: !important monospace;
    }

    #editor { 
        position: absolute;
        top: 25%;
        right: 0;
        bottom: 0;
        left: 25%;
        width: 30%;
        height: 30%;
    }
  </style>
  <body>
 <nav class="navbar bg-primary" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand my-2" href="#">
      <img src="PHP.png" alt="Bootstrap" style="width:10%;" class="mx-4">
      Scan Javascript's Tokens With PHP
    </a>
  </div>
</nav> 

<div class="code-editor mt-4">
  <div class="container">
  <div class="row">
    <div class="col">
      <img src="js.png" alt="Bootstrap" style="width:5%;" class="my-2"><br>
      <div class="input-group mb-3">
      <input type="file" class="form-control" id="fileInput" accept=".js">
        <label class="input-group-text" for="inputGroupFile02">Upload</label>
      </div>
      <form action="#tokens" method="post"> 
        <?php if (!empty($_POST['js-code'])) : ?>
          <textarea id="fileContent" placeholder="Mulai mengetik atau unggah file javascript" width="400px" 
          name="js-code" style="font-family: Monospace; background-color: #1b1b1b; color: white;"><?= $_POST['js-code'] ?></textarea>
        <?php else : ?>
          <textarea id="fileContent" placeholder="Mulai mengetik atau unggah file javascript" width="400px" name="js-code" 
          style="font-family: Monospace;background-color: #1b1b1b; color: white;"></textarea>
        <?php endif; ?>
      <div class="col-auto" align="right">
        <button type="submit" class="btn btn-primary mb-3" id="scan">Scan Kode Ini</button>
      </div>
      </form>
    </div>
  </div>
  </div>
</div>

<?php if(isset($_POST['js-code'])) : ?>
<?php $tokens = getTokens(); ?>
<?php $t_k = $tokens['keyword'][0];?>
<?php $t_d = $tokens['delimiter'][0];?>
<?php $t_o = $tokens['operator'][0];?>
<?php $t_vn = $tokens['value_number'][0];?>
<?php $t_vs = $tokens['value_string'][0];?>
<?php $t_va = $tokens['value_array'][0];?>
<?php $t_v = $tokens['variabel'][0];?>
<?php $t_f = $tokens['nama_fungsi'][0];?>
<div class="tokens container mt-4" id="tokens" style="height:150vh;">
  <h2><img src="semicolon.png" alt="Bootstrap" style="width:5%;" class="mx-4">Token Yang Didapatkan</h2>
  <div class="table-group-divider mt-4 mb-2"></div>
  <div class="keyword my-4">

  <h2><span class="badge rounded-pill text-bg-dark mx-2">Identifier</span></h2>
    <h4><span class="badge rounded-pill text-bg-primary">Token Keyword</span></h4>
    <?php foreach($t_k as $k ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $k ?></span>
    <?php endforeach; ?>
  </div>
  <div class="variabe my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Variabel</span></h4>
    <?php foreach($t_v as $v ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $v ?></span>
    <?php endforeach; ?>
  </div>
  <div class="variabe my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Nama Fungsi</span></h4>
    <?php foreach($t_f as $f ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $f ?></span>
    <?php endforeach; ?>
  </div>
  <h2><span class="badge rounded-pill text-bg-dark mx-2">Operator & Delimiter</span></h2>
  <div class="operator my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Operator</span></h4>
    <?php foreach($t_o as $o ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $o ?></span>
    <?php endforeach; ?>
  </div>
  <div class="delimiter my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Delimiter</span></h4>
    <?php foreach($t_d as $d ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $d ?></span>
    <?php endforeach; ?>
  </div>
   <h2><span class="badge rounded-pill text-bg-dark mx-2">Nilai Konstanta</span></h2>
  <div class="nilai-konstanta-number my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Nilai Konstanta (Number)</span></h4>
    <?php foreach($t_vn as $vn ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $vn ?></span>
    <?php endforeach; ?>
  </div>
  <div class="nilai-konstanta-string my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Nilai Konstanta (String)</span></h4>
    <?php foreach($t_vs as $vs ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $vs ?></span>
    <?php endforeach; ?>
  </div>
  <div class="nilai-konstanta-string my-4">
    <h4><span class="badge rounded-pill text-bg-primary">Token Nilai Konstanta (Array)</span></h4>
    <?php foreach($t_va as $va ) : ?>
      <span class="mx-2 badge text-bg-info"><?= $va ?></span>
    <?php endforeach; ?>
  </div>
  
</div>
<br><br><br>
<?php endif; ?>

<script>
  document.getElementById('fileInput').addEventListener('change', function() {
    const fileInput = this;
    const fileReader = new FileReader();

    fileReader.onload = function() {
      const fileContent = fileReader.result;
      document.getElementById('fileContent').value = fileContent;
    };

    const selectedFile = fileInput.files[0];
    if (selectedFile) {
      fileReader.readAsText(selectedFile);
    }
  });
 </script>
 <!-- editor highlighter -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ace.js"></script>
<script>  
  var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/javascript");
</script>
  </body>
</html>