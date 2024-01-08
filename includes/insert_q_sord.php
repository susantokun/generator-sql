<?php
include('db_connection.php');

function run_insert_q_sord($data, $conn, $tahun)
{
    $sql_q_sord = "INSERT INTO `q_sord` (
        `kd_prsh`, 
        `tx_tahn`, 
        `kd_sord`, 
        `no_sord`, 
        `jl_kuan`,
        `kd_kprd`, 
        `nl_sord`, 
        `nl_base`, 
        `tx_kurs`, 
        `ob_hrga`, 
        `tg_delv`
    ) VALUES ";

    foreach ($data as $row) {
        $string = $row[1];
        $parts = explode("/", $string);
        $get_string = $parts[0];
        $get_nomor = intval($get_string);
        $get_padded = str_pad($get_nomor, 6, '0', STR_PAD_LEFT);

        $harga = floatval(str_replace(',', '', $row[3]));

        $kd_prsh = 'SPS0';
        $tx_tahn = $tahun;
        $kd_sord = 'SP' . $get_padded;
        $no_sord = '0001';
        $jl_kuan = '0';
        $kd_kprd = 'SPSJKT';
        $nl_sord = $harga;
        $nl_base = $harga;
        $tx_kurs = 'IDR';
        $ob_hrga = $kd_sord . 'NORM00';
        $tg_delv = '0000-00-00';

        $values = [
            $kd_prsh, // kd_prsh
            $tx_tahn, // tx_tahn
            $kd_sord, // kd_sord
            $no_sord, // no_sord
            $jl_kuan, // jl_kuan
            $kd_kprd, // kd_kprd
            $nl_sord, // nl_sord
            $nl_base, // nl_base
            $tx_kurs, // tx_kurs
            $ob_hrga, // ob_hrga
            $tg_delv, // tg_delv
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sord .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris kedua
        $values[0] = $kd_prsh; // kd_prsh
        $values[1] = $tx_tahn; // tx_tahn
        $values[2] = 'SD' . $get_padded; // kd_sord
        $values[3] = $no_sord; // no_sord
        $values[4] = $jl_kuan; // jl_kuan
        $values[5] = $kd_kprd; // kd_kprd
        $values[6] = $nl_sord; // nl_sord
        $values[7] = $nl_base; // nl_base
        $values[8] = $tx_kurs; // tx_kurs
        $values[9] = $values[2] . 'NORM00'; // ob_hrga
        $values[10] = $tg_delv; // tg_delv

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sord .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sord = rtrim($sql_q_sord, ', ');

    $update_values[] = "
        `jl_kuan` = VALUES(`jl_kuan`),
        `kd_kprd` = VALUES(`kd_kprd`),
        `nl_sord` = VALUES(`nl_sord`),
        `nl_base` = VALUES(`nl_base`),
        `tx_kurs` = VALUES(`tx_kurs`),
        `ob_hrga` = VALUES(`ob_hrga`),
        `tg_delv` = VALUES(`tg_delv`);
    \n";

    $sql_q_sord .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sord...\n";

    if ($conn->query($sql_q_sord) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sord\n\n";
    } else {
        echo "Error: " . $sql_q_sord . "<br>" . $conn->error;
    }
}
