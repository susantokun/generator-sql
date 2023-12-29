<?php
include('db_connection.php');

function run_insert_q_sors($data, $conn, $tahun)
{
    $sql_q_sors = "INSERT INTO `q_sors` (
        `kd_prsh`, 
        `tx_tahn`, 
        `ob_stra`, 
        `kd_stra`, 
        `no_stra`, 
        `fl_fap1`, 
        `fl_ap1a`, 
        `tg_ap1a`, 
        `tg_ap1b`, 
        `tg_ap2a`, 
        `tg_ap2b`, 
        `tg_ap3a`, 
        `tg_ap3b`
        )
    VALUES ";

    foreach ($data as $row) {
        $get_nomor = substr($row[1], 0, 3);
        $converted_tanggal = DateTime::createFromFormat('m/d/Y', $row[2])->format('Y-m-d');

        $kd_prsh = 'SPS0';
        $tx_tahn = $tahun;
        $ob_stra = 'STRASP000' . $get_nomor;
        $kd_stra = 'L11A';
        $no_stra = '1';
        $fl_fap1 = 'X';
        $fl_ap1a = 'X';
        $tg_ap1a = $converted_tanggal;
        $tg_ap1b = '0000-00-00';
        $tg_ap2a = '0000-00-00';
        $tg_ap2b = '0000-00-00';
        $tg_ap3a = '0000-00-00';
        $tg_ap3b = '0000-00-00';

        $values = [
            $kd_prsh, // kd_prsh
            $tx_tahn, // tx_tahn
            $ob_stra, // ob_stra
            $kd_stra, // kd_stra
            $no_stra, // no_stra
            $fl_fap1, // fl_fap1
            $fl_ap1a, // fl_ap1a
            $tg_ap1a, // tg_ap1a
            $tg_ap1b, // tg_ap1b
            $tg_ap2a, // tg_ap2a
            $tg_ap2b, // tg_ap2b
            $tg_ap3a, // tg_ap3a
            $tg_ap3b, // tg_ap3b
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sors .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris kedua
        $values[0] = $kd_prsh; // kd_prsh
        $values[1] = $tx_tahn; // tx_tahn
        $values[2] = 'STRASD000' . $get_nomor; // ob_stra
        $values[3] = 'L21A'; // kd_stra
        $values[4] = $no_stra; // no_stra
        $values[5] = ''; // fl_fap1
        $values[6] = ''; // fl_ap1a
        $values[7] = '0000-00-00'; // tg_ap1a
        $values[8] = $tg_ap1b; // tg_ap1b
        $values[9] = $tg_ap2a; // tg_ap2a
        $values[10] = $tg_ap2b; // tg_ap2b
        $values[11] = $tg_ap3a; // tg_ap3a
        $values[12] = $tg_ap3b; // tg_ap3b

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sors .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sors = rtrim($sql_q_sors, ', ');

    $update_values[] = "
        `fl_fap1` = VALUES(`fl_fap1`),
        `fl_ap1a` = VALUES(`fl_ap1a`),
        `tg_ap1a` = VALUES(`tg_ap1a`),
        `tg_ap1b` = VALUES(`tg_ap1b`),
        `tg_ap2a` = VALUES(`tg_ap2a`),
        `tg_ap2b` = VALUES(`tg_ap2b`),
        `tg_ap3a` = VALUES(`tg_ap3a`),
        `tg_ap3b` = VALUES(`tg_ap3b`);
    \n";

    $sql_q_sors .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sors...\n";

    if ($conn->query($sql_q_sors) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sors\n\n";
    } else {
        echo "Error: " . $sql_q_sors . "<br>" . $conn->error;
    }
}
