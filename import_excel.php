<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include('db_connection.php');

include('includes/check_m_mtra.php');

include('includes/insert_q_sors.php');
include('includes/insert_q_sorh.php');
include('includes/insert_q_sord.php');
include('includes/insert_q_sorl.php');
include('includes/insert_q_sorp.php');
include('includes/insert_q_proh.php');
include('includes/insert_q_prod.php');
include('includes/insert_q_sorb.php');

if ($argc < 2) {
  die("Usage: php import_excel.php <excel_file_path>\n");
}

$tahun = getenv('APP_TAHUN');
$nomor_sheet = getenv('APP_NOMOR_SHEET');

$excelFile = $argv[1];
$spreadsheet = IOFactory::load($excelFile);
$sheet = $spreadsheet->getSheet($nomor_sheet);
$data = array_slice($sheet->toArray(), 1);

$count_not_found_m_mtra = run_check_m_mtra($data, $conn, $tahun)['count_not_found_m_mtra'];

if ($count_not_found_m_mtra === 0) {
  run_insert_q_sors($data, $conn, $tahun);
  run_insert_q_sorh($data, $conn, $tahun);
  run_insert_q_sord($data, $conn, $tahun);
  run_insert_q_sorl($data, $conn, $tahun);
  run_insert_q_sorp($data, $conn, $tahun);
  run_insert_q_proh($data, $conn, $tahun);
  run_insert_q_prod($data, $conn, $tahun);
  run_insert_q_sorb($data, $conn, $tahun);
} else {
  echo "Tidak dapat menjalankan kode lain karena terdapat tx_mtra yang tidak ditemukan.\n";
}
