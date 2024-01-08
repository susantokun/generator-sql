<?php
include('db_connection.php');

function run_insert_q_sorp($data, $conn, $tahun)
{
    $sql_q_sorp = "INSERT INTO `q_sorp` (
        `kd_prsh`,
        `tx_tahn`,
        `ob_hrga`,
        `no_obhr`,
        `no_coun`,
        `nl_hakh`,
        `kd_kurh`,
        `nl_base`,
        `nl_pegt`,
        `nl_pkwt`,
        `kd_kurb`,
        `pr_fhrg`,
        `nl_fhra`,
        `kd_kurf`,
        `tg_buat`,
        `tx_buat`,
        `tg_ubah`,
        `tx_ubah`
        )
    VALUES ";

    foreach ($data as $row) {
        $string = $row[1];
        $parts = explode("/", $string);
        $get_string = $parts[0];
        $get_nomor = intval($get_string);
        $get_padded = str_pad($get_nomor, 6, '0', STR_PAD_LEFT);

        $converted_tanggal = DateTime::createFromFormat('m/d/Y', $row[2])->format('Y-m-d');
        $harga = floatval(str_replace(',', '', $row[3]));
        
        $kd_prsh = 'SPS0';
        $tx_tahn = $tahun;
        $ob_hrga = 'SP' . $get_padded . 'NORM00';
        $no_obhr = '001';
        $no_coun = '1';
        $nl_hakh = $harga;
        $kd_kurh = 'IDR';
        $nl_base = $harga;
        $nl_pegt = $harga;
        $nl_pkwt = '0';
        $kd_kurb = 'IDR';
        $pr_fhrg = '';
        $nl_fhra = '0';
        $kd_kurf = 'IDR';
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $tx_tahn, // tx_tahn
            $ob_hrga, // ob_hrga
            $no_obhr, // no_obhr
            $no_coun, // no_coun
            $nl_hakh, // nl_hakh
            $kd_kurh, // kd_kurh
            $nl_base, // nl_base
            $nl_pegt, // nl_pegt
            $nl_pkwt, // nl_pkwt
            $kd_kurb, // kd_kurb
            $pr_fhrg, // pr_fhrg
            $nl_fhra, // nl_fhra
            $kd_kurf, // kd_kurf
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorp .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris kedua
        $values[0] = $kd_prsh; // kd_prsh
        $values[1] = $tx_tahn; // tx_tahn
        $values[2] = 'SD' . $get_padded . 'NORM00'; // ob_hrga
        $values[3] = ''; // no_obhr
        $values[4] = $no_coun; // no_coun
        $values[5] = $nl_hakh; // nl_hakh
        $values[6] = $kd_kurh; // kd_kurh
        $values[7] = $nl_base; // nl_base
        $values[8] = $nl_pegt; // nl_pegt
        $values[9] = $nl_pkwt; // nl_pkwt
        $values[10] = $kd_kurb; // kd_kurb
        $values[11] = 'N'; // pr_fhrg
        $values[12] = $nl_fhra; // nl_fhra
        $values[13] = $kd_kurf; // kd_kurf
        $values[14] = $tg_buat; // tg_buat
        $values[15] = $tx_buat; // tx_buat
        $values[16] = $tg_ubah; // tg_ubah
        $values[17] = $tx_ubah; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorp .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sorp = rtrim($sql_q_sorp, ', ');

    $update_values[] = "
        `nl_hakh` = VALUES(`nl_hakh`),
        `kd_kurh` = VALUES(`kd_kurh`),
        `nl_base` = VALUES(`nl_base`),
        `nl_pegt` = VALUES(`nl_pegt`),
        `nl_pkwt` = VALUES(`nl_pkwt`),
        `kd_kurb` = VALUES(`kd_kurb`),
        `pr_fhrg` = VALUES(`pr_fhrg`),
        `nl_fhra` = VALUES(`nl_fhra`),
        `kd_kurf` = VALUES(`kd_kurf`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_sorp .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sorp...\n";

    if ($conn->query($sql_q_sorp) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sorp\n\n";
    } else {
        echo "Error: " . $sql_q_sorp . "<br>" . $conn->error;
    }
}
