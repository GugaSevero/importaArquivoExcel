<!DOCTYPE html>
<html>
<head>
	<title>Importa Dado CSV</title>
</head>
<body>

<form method="post" enctype="multipart/form-data" action="">
	<input type="file" name="arquivo">
	<input type="submit" name="pega" value="pega">
</form>

<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

if (isset($_POST['pega'])) {
	
include_once("PHPExcel/Classes/PHPExcel.php");

$uploadDir = "/uploadFile";

$uploadfile = $uploadDir . $_FILES['arquivo']['name'];

if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {
	echo "Arquivo pego com sucesso";
}else{
	echo "Não foi possível pegar arquivo";
}

$objReader = new PHPExcel_Reader_Excel5();
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load("$uploadDir/Fluxo_de_caixa_VP_1015");

$colunas  = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
$totalColunas = PHPExcel_Cell::columnByIndexFromString($colunas);

$totalLinhas = $objPHPExcel->setActiveSheetIndex(0)->getHighetRows();

for ($linha=1; $linha <= $totalLinhas; $linha++) { 

	for ($coluna=0; $coluna <= $totalColunas; $coluna++) { 

		if ($linha == 1) {
			echo utf8_decode($objPHPExcel->getActiveSheet()->getCellColumnAndRow($coluna,$linha)->getValue());
		}else{
			echo utf8_decode($objPHPExcel->getActiveSheet()->getCellColumnAndRow($coluna,$linha)->getValue());
		}
		
	}
}

//CÓDIGO 1
/*if (isset($_POST['pega'])) {

	include_once("../PHPExcel/Classes/PHPExcel.php");
	include_once("../PHPExcel/Classes/Autoloader.php");

	$file = $_FILES['arquivo'];
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($file);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
	$csvFileName = str_replace('.xlsx', '.csv', $file);
	$objWriter->save($csvFileName);
	if (($handle = fopen($csvFileName, "r")) !== false) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
	        $num = count($data);
	        echo "<p> $num campos na linha $row: <br /></p>\n";
	        $row++;
	        for ($c = 0; $c < $num; $c++) {
	            echo $data[$c] . "<br />\n";
	        }
	    }
	    fclose($handle);
	}
*/

//CÓDIGO 2
	/*$arquivo = $_FILES['arquivo'];
	//print_r($arquivo);
	$file = fopen($arquivo,"r");

	while(! feof($file))
	  {
	  echo fgets($file). "<br />";
	  }

	fclose($file);
	/*$objeto = fopen($nome_arquivo, 'r');

	while (($dados = fgetcsv($objeto, 1000, '')) !== FALSE) {
		
		echo '<pre>';
		print_r($dados);
		echo '</pre>';
	}*/
}

?>
</body>
</html>
