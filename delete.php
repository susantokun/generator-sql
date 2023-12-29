<?php
include('db_connection.php');

$tahun = getenv('APP_TAHUN_DELETE');

deleteDataByYear('q_sors', $conn, $tahun);
deleteDataByYear('q_sorh', $conn, $tahun);
deleteDataByYear('q_sord', $conn, $tahun);
deleteDataByYear('q_sorl', $conn, $tahun);
deleteDataByYear('q_sorp', $conn, $tahun);
deleteDataByYear('q_proh', $conn, $tahun);
deleteDataByYear('q_prod', $conn, $tahun);
deleteDataByYear('q_sorb', $conn, $tahun);

function deleteDataByYear($tableName, $conn, $tahun)
{
  $tahunArray = explode(",", $tahun);

  $inClause = implode(",", array_map(function ($value) {
    return "'" . trim($value) . "'";
  }, $tahunArray));

  $sql_delete = "DELETE FROM `$tableName` WHERE `tx_tahn` IN ($inClause)";

  echo "Sedang menghapus data untuk tabel $tableName...\n";

  if ($conn->query($sql_delete) === TRUE) {
    echo "Data berhasil dihapus dari tabel $tableName\n";
  } else {
    echo "Error: " . $sql_delete . "<br>" . $conn->error;
  }
}
