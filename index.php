<?php
include('db_connection.php');

function importExcel($excelFile)
{
    echo "Mengimport data dari Excel...\n";
    $command = "php import_excel.php $excelFile";
    $output = shell_exec($command);
    echo $output;
}
$excelFile = getenv('APP_DIRECTORY_FILE');
importExcel($excelFile);

echo "***** Semua skrip telah dijalankan *****\n";

$conn->close();

// for generate run php index.php
// for delete run php delete.php
// change .env file for your dream