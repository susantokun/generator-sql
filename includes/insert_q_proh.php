<?php
include('db_connection.php');

function run_insert_q_proh($data, $conn, $tahun)
{
    $sql_q_proh = "INSERT INTO `q_proh` (
        `kd_prsh`,
        `kd_kprd`,
        `tx_tahn`,
        `kd_linp`,
        `tp_sord`,
        `kd_prod`,
        `kd_rutp`,
        `kd_sord`,
        `kd_ekst`,
        `tg_ekst`,
        `tx_prod`,
        `tg_awal`,
        `tg_akhr`,
        `fl_aptk`,
        `fl_prcl`,
        `fl_bill`,
        `tg_aptk`,
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
        $no_spk = $row[1] ?? "";

        $kd_prsh = 'SPS0';
        $kd_kprd = 'SPSJKT';
        $tx_tahn = $tahun;
        $kd_linp = 'T0';
        $tp_sord = 'JS01';
        $kd_prod = 'PD' . $get_padded;
        $kd_rutp = 'RP2402';
        $kd_sord = 'SD' . $get_padded;
        $kd_ekst = $no_spk;
        $tg_ekst = $converted_tanggal;
        $tx_prod = 'GENERATE';
        $tg_awal = $converted_tanggal;
        $tg_akhr = $converted_tanggal;
        $fl_aptk = 'X';
        $fl_prcl = 'X';
        $fl_bill = 'X';
        $tg_aptk = $converted_tanggal;
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $kd_kprd, // kd_kprd
            $tx_tahn, // tx_tahn
            $kd_linp, // kd_linp
            $tp_sord, // tp_sord
            $kd_prod, // kd_prod
            $kd_rutp, // kd_rutp
            $kd_sord, // kd_sord
            $kd_ekst, // kd_ekst
            $tg_ekst, // tg_ekst
            $tx_prod, // tx_prod
            $tg_awal, // tg_awal
            $tg_akhr, // tg_akhr
            $fl_aptk, // fl_aptk
            $fl_prcl, // fl_prcl
            $fl_bill, // fl_bill
            $tg_aptk, // tg_aptk
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);

        $sql_q_proh .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_proh = rtrim($sql_q_proh, ', ');

    $update_values[] = "
        `kd_rutp` = VALUES(`kd_rutp`),
        `kd_sord` = VALUES(`kd_sord`),
        `kd_ekst` = VALUES(`kd_ekst`),
        `tg_ekst` = VALUES(`tg_ekst`),
        `tx_prod` = VALUES(`tx_prod`),
        `tg_awal` = VALUES(`tg_awal`),
        `tg_akhr` = VALUES(`tg_akhr`),
        `fl_aptk` = VALUES(`fl_aptk`),
        `fl_prcl` = VALUES(`fl_prcl`),
        `fl_bill` = VALUES(`fl_bill`),
        `tg_aptk` = VALUES(`tg_aptk`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_proh .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_proh...\n";

    if ($conn->query($sql_q_proh) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_proh\n\n";
    } else {
        echo "Error: " . $sql_q_proh . "<br>" . $conn->error;
    }
}
