<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Importa Dado CSV</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="arquivo">
	<input type="submit" name="pega" value="pega">
</form>

<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

//CÓDIGO 1
if (isset($_POST['pega'])) {

	include_once("PHPExcel/Classes/PHPExcel.php");

	$uploadDir = "uploadFile/";

	$uploadfile = $uploadDir . $_FILES['arquivo']['name'];

	if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {
		echo "Arquivo pego com sucesso";
	}else{
		echo "Não foi possível pegar arquivo";
	}

	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($uploadfile);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
	$csvFileName = str_replace('.xlsx', '.csv', $uploadfile);
	$objWriter->save($csvFileName);
	if (($handle = fopen($csvFileName, "r")) !== false) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
	        $num = count($data);
	        for ($c = 0; $c < $num; $c++) {
	            echo $data[$c] . "<br />\n";
	        }
	    }
	    fclose($handle);
	}

	$objReader = new PHPExcel_Reader_Excel5();
	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load("uploadfile");

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

}

?>
</body>
</html>
