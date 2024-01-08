<?php
include('db_connection.php');

function run_insert_q_sorl($data, $conn, $tahun)
{
    $sql_q_sorl = "INSERT INTO `q_sorl` (
        `kd_prsh`, 
        `tx_tahn`, 
        `kd_sord`, 
        `ln_ref1`, 
        `kd_bhs1`, 
        `tx_ref2`, 
        `ln_ref2`, 
        `tg_buat`, 
        `tx_buat`, 
        `tg_ubah`, 
        `tx_ubah`
    ) VALUES ";

    foreach ($data as $row) {
        $string = $row[1];
        $parts = explode("/", $string);
        $get_string = $parts[0];
        $get_nomor = intval($get_string);
        $get_padded = str_pad($get_nomor, 6, '0', STR_PAD_LEFT);

        $converted_tanggal = DateTime::createFromFormat('m/d/Y', $row[2])->format('Y-m-d');
        $file_spk_nama = $tahun . "_" . 'SP' . $get_padded . ".pdf";
        $file_spk_url = "https://admin.kka-nurichwan.com/uploads/";

        $kd_prsh = 'SPS0';
        $tx_tahn = $tahun;
        $kd_sord = 'SP' . $get_padded;
        $ln_ref1 = '';
        $kd_bhs1 = 'ID';
        $tx_ref2 = $file_spk_nama;
        $ln_ref2 = $file_spk_url .  $file_spk_nama;
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $tx_tahn, // tx_tahn
            $kd_sord, // kd_sord
            $ln_ref1, // ln_ref1
            $kd_bhs1, // kd_bhs1
            $tx_ref2, // tx_ref2
            $ln_ref2, // ln_ref2
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);

        $sql_q_sorl .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris kedua
        $values[0] = $kd_prsh; // kd_prsh
        $values[1] = $tx_tahn; // tx_tahn
        $values[2] = 'SD' . $get_padded; // kd_sord
        $values[3] = $file_spk_url; // ln_ref1
        $values[4] = $kd_bhs1; // kd_bhs1
        $values[5] = ''; // tx_ref2
        $values[6] = ''; // ln_ref2
        $values[7] = $tg_buat; // tg_buat
        $values[8] = $tx_buat; // tx_buat
        $values[9] = $tg_ubah; // tg_ubah
        $values[10] = $tx_ubah; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorl .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris ketiga
        $values[2] = 'SB' . $get_padded; // kd_sord
        $values[3] = $file_spk_url; // ln_ref1
        $values[5] = ''; // tx_ref2
        $values[6] = ''; // ln_ref2

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorl .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sorl = rtrim($sql_q_sorl, ', ');

    $update_values[] = "
        `ln_ref1` = VALUES(`ln_ref1`),
        `kd_bhs1` = VALUES(`kd_bhs1`),
        `tx_ref2` = VALUES(`tx_ref2`),
        `ln_ref2` = VALUES(`ln_ref2`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_sorl .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sorl...\n";

    if ($conn->query($sql_q_sorl) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sorl\n\n";
    } else {
        echo "Error: " . $sql_q_sorl . "<br>" . $conn->error;
    }
}
