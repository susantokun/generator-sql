<?php
include('db_connection.php');

function run_check_m_mtra($data, $conn, $tahun)
{
  $count_found = 0;
  $count_not_found = 0;
  $unique_tx_mtra = [];

  foreach ($data as $row) {
    $tx_mtra = $row[0];
    $check_mtra_query = "SELECT * FROM m_mtra WHERE tx_mtra = '$tx_mtra'";
    $check_mtra_result = $conn->query($check_mtra_query);

    if ($check_mtra_result->num_rows > 0) {
      $count_found++;
    } else {
      $count_not_found++;
      if (!in_array($tx_mtra, $unique_tx_mtra)) {
        $unique_tx_mtra[] = $tx_mtra;
      }
    }
  }

  echo "Checking...\n";
  echo "-----\n";

  if (count($unique_tx_mtra) > 0) {
    echo "Data tx_mtra yang tidak ditemukan (unique):\n";
    echo "-----\n";
    foreach ($unique_tx_mtra as $unique_tx) {
      echo $unique_tx . "\n";
    }
  }

  echo "Jumlah tx_mtra yang ditemukan: $count_found\n";
  echo "Jumlah tx_mtra yang tidak ditemukan: $count_not_found\n";
  echo "Jumlah tx_mtra yang tidak ditemukan (unique): " . count($unique_tx_mtra) . "\n-----\n\n";

  return [
    'count_not_found_m_mtra' => $count_not_found,
  ];
}
