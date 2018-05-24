<?php

$msj = "";
defined('BASEPATH') OR exit('No direct script access allowed');
include 'PHPExcel-1.8.1/Classes/PHPExcel.php';       // include the class

class KPI extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data/dao_kpi_model');
        $this->load->model('data/configdb_model');

    }

    public function KPIPrincial(){
      $this->load->view('viewKPI');
    }

    public function KPIList(){
      $KPIs = $this->dao_kpi_model->getAllKPI();
      for($i = 0; $i< count($KPIs); $i++){
        print_r($KPIs[$i]);
        echo "<br><br>";
      }
    }

    public function getKPIperSource(){
      $respuesta['KPIsPP'] = $this->dao_kpi_model->getKPIperSource($_SESSION['id']);
      $respuesta['msj'] = $GLOBALS['$msj'];
      $this->load->view('viewKPI', $respuesta);
    }

    public function evaluateKPI(){
      $personas = $this->dao_kpi_model->getKPIEvaluates($_GET['k_kpi']);
      $respuesta['dates'] = $personas[1];
      $respuesta['kpis'] = $personas[2];
      $respuesta['cantidad'] = $personas[3];
      $this->load->view('qualifyKPIs', $respuesta);
    }

    public function updateKPI(){
      $index = 0;
      $cell['cell1'] = $_POST['cell1']."<br>";
      $cell['cell2'] = $_POST['cell2']."<br>";
      $cell['cell3'] = $_POST['cell3']."<br>";
      $cell['kpi'] = $_POST['kpi']."<br>";

      for($i = 0; $i < $_POST['cantidadY']; $i++){
        for($j = 0; $j < 12; $j++){
          for($k = 0; $k < $_POST['cantidadU']; $k++){
            if($_POST['idKPI-'.$i."-".$j."-".$k]){
              $kpi[$index]['id'] = $_POST['idKPI-'.$i."-".$j."-".$k];
              $kpi[$index]['name'] = $_POST['name-'.$i."-".$j."-".$k];
              if($_POST['field-'.$i."-".$j."-".$k."-1"] != null){
                $kpi[$index]['value1'] = $_POST['field-'.$i."-".$j."-".$k."-1"]."<br>";
              }
              if($_POST['field-'.$i."-".$j."-".$k."-2"] != null){
                $kpi[$index]['value2'] = $_POST['field-'.$i."-".$j."-".$k."-2"]."<br>";
              }
              if($_POST['field-'.$i."-".$j."-".$k."-3"] != null){
                $kpi[$index]['value3'] = $_POST['field-'.$i."-".$j."-".$k."-3"]."<br>";
              }
              $index++;
            }
          }
        }
      }
    //  $respuesta = $this->exportXL($kpi, $cell);
      $respuesta = $this->dao_kpi_model->updateKPIResuelto($kpi);
      if ($respuesta == "false"){
        $GLOBALS['$msj'][0] = "Algo salio mal";
        $GLOBALS['$msj'][1] = "Contacte al administrador del servicio";
        $GLOBALS['$msj'][2] = "error";
      } else {
        $GLOBALS['$msj'][0] = "Bien Hecho";
        $GLOBALS['$msj'][1] = "Información actualizada";
        $GLOBALS['$msj'][2] = "success";
      }
      $this->getKPIperSource();
    }


    public function dw(){
      PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

        $objPHPExcel = PHPExcel_IOFactory::load("archivos/KPI.xlsx");
        //  $objPHPExcel->getActiveSheet()->setCellValue('A1', 'hello world!');
        //  $objPHPExcel->getActiveSheet()->setTitle('Chesse1');
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="KPI.xlsx"');
          header('Cache-Control: max-age=0');
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
        }



    public function exportXL($kpi, $cell){
      for ($i = 0; $cell['kpi'][$i] != "<"; $i++){
        $q = $q.$cell['kpi'][$i];
      }
      PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
      $objPHPExcel = PHPExcel_IOFactory::load("archivos/KPI.xlsx");
      $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(0, 1,  'nombre');
      $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(1, 1, $cell['cell1']." ");
      $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(2, 1, $cell['cell2']." ");
      $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(3, 1, $cell['cell3']." ");
      for($i = 0; $i < count($kpi); $i++){
        $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(0, $i+2, $kpi[$i]['name']);

        if($kpi[$i]['value1'] != NULL){
          $m = "";
          for ($x = 0; $kpi[$i]['value1'][$x] != "<"; $x++){
            $m = $m.$kpi[$i]['value1'][$x];
          }
          $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(1, $i+2, $m);
        }
        if($kpi[$i]['value2'] != NULL){
          $m = "";
          for ($x = 0; $kpi[$i]['value2'][$x] != "<"; $x++){
            $m = $m.$kpi[$i]['value2'][$x];
          }
          $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(2, $i+2, $m);
        }
        if($kpi[$i]['value3'] != NULL){
          $m = "";
          for ($x = 0; $kpi[$i]['value3'][$x] != "<"; $x++){
            $m = $m.$kpi[$i]['value3'][$x];
          }
          $objPHPExcel->getSheetByName($q)->setCellValueByColumnAndRow(3, $i+2, $m);
        }
      }
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
      $objWriter->save("archivos/KPI.xlsx");
      $callEndTime = microtime(true);
    $callTime = $callEndTime - $callStartTime;
    }


    function download(){
      $filename = $_GET['n_name'];
      echo $filename;
      if(!empty($filename)){
        // Specify file path.
        $path = 'archivos/'; // '/uplods/'
        $download_file =  $path.$filename;}
        echo $download_file;
        // Check file is exists on given path.
        if(file_exists($download_file))
        {
          // Getting file extension.
          $extension = explode('.',$filename);
          $extension = $extension[count($extension)-1];
          // For Gecko browsers
          header('Content-Transfer-Encoding: binary');
          header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
          // Supports for download resume
          header('Accept-Ranges: bytes');
          // Calculate File size
          header('Content-Length: ' . filesize($download_file));
          header('Content-Encoding: none');
          // Change the mime type if the file is not PDF
          header('Content-Type: application/'.$extension);
          // Make the browser display the Save As dialog
          header('Content-Disposition: attachment; filename=' . $filename);
          readfile($download_file);
          exit;
        }
        else
        {
          echo 'File does not exists on given path';
        }
     }



    function downloadFile() {
      $path = "archivos/"; // change the path to fit your websites document structure
      $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', 'KPI.xlsx'); // simple file name validation
      $fullPath = "archivos/KPI.xlsx";

      if ($fd = fopen ($fullPath, "r")) {
          $fsize = filesize($fullPath);
          $path_parts = pathinfo($fullPath);
          $ext = strtolower($path_parts["extension"]);
          switch ($ext) {
              case "pdf":
              header("Content-type: application/pdf");
              header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
              break;
              default;
              header("Content-type: application/octet-stream");
              header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
              break;
          }
          header("Content-length: $fsize");
          header("Cache-control: private"); //use this to open files directly
          while(!feof($fd)) {
              $buffer = fread($fd, 2048);
              echo $buffer;
          }
      }
      fclose ($fd);
      exit;
  }



}

?>
