<?php
include('db_connection.php');

function run_insert_q_prod($data, $conn, $tahun)
{
    $sql_q_prod = "INSERT INTO `q_prod` (
        `kd_prsh`,
        `kd_kprd`,
        `tx_tahn`,
        `kd_prod`,
        `kd_rutp`,
        `no_rutp`,
        `tx_rutp`,
        `tg_awal`,
        `tg_akhr`,
        `tx_ref1`,
        `ln_ref1`,
        `fl_aprv`,
        `fl_aktv`,
        `tg_aprv`,
        `fl_apr2`,
        `tg_apr2`,
        `tg_buat`,
        `tx_buat`,
        `tg_ubah`,
        `tx_ubah`
    ) VALUES ";

    foreach ($data as $row) {
        $get_nomor = substr($row[1], 0, 3);
        $converted_tanggal = DateTime::createFromFormat('m/d/Y', $row[2])->format('Y-m-d');
        $dok_draf_psak24 = $tahun . "_" . 'PD000' . $get_nomor . "_dok_draf_psak24.pdf";
        $dok_rev_draft_final = $tahun . "_" . 'PD000' . $get_nomor . "_dok_rev_draft_final.pdf";
        $approval_psak24 = $tahun . "_" . 'PD000' . $get_nomor . "_approval_psak24.pdf";
        $dok_final_psak24 = $tahun . "_" . 'PD000' . $get_nomor . "_dok_final_psak24.pdf";

        $kd_prsh = 'SPS0';
        $kd_kprd = 'SPSJKT';
        $tx_tahn = $tahun;
        $kd_prod = 'PD000' . $get_nomor;
        $kd_rutp = 'RP2402';
        $no_rutp = '1';
        $tx_rutp = 'DATA DASAR';
        $tg_awal = $converted_tanggal;
        $tg_akhr = $converted_tanggal;
        $tx_ref1 = '';
        $ln_ref1 = '';
        $fl_aprv = 'X';
        $fl_aktv = '';
        $tg_aprv = $converted_tanggal;
        $fl_apr2 = 'X';
        $tg_apr2 = $converted_tanggal;
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $kd_kprd, // kd_kprd
            $tx_tahn, // tx_tahn
            $kd_prod, // kd_prod
            $kd_rutp, // kd_rutp
            $no_rutp, // no_rutp
            $tx_rutp, // tx_rutp
            $tg_awal, // tg_awal
            $tg_akhr, // tg_akhr
            $tx_ref1, // tx_ref1
            $ln_ref1, // ln_ref1
            $fl_aprv, // fl_aprv
            $fl_aktv, // fl_aktv
            $tg_aprv, // tg_aprv
            $fl_apr2, // fl_apr2
            $tg_apr2, // tg_apr2
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 2
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '2'; // no_rutp
        $values[6] = 'DOK DRAFT PSAK24'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = $dok_draf_psak24; // tx_ref1
        $values[10] = 'https://admin.kka-nurichwan.com/upload/' . $dok_draf_psak24; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 3
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '3'; // no_rutp
        $values[6] = 'SUBMIT DRAFT 1 PSAK2'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = ''; // tx_ref1
        $values[10] = ''; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 4
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '4'; // no_rutp
        $values[6] = 'REVISI DRAFT PSAK24'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = ''; // tx_ref1
        $values[10] = ''; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 5
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '5'; // no_rutp
        $values[6] = 'DOK REV DRAFT 2 PSAK'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = '0000-00-00'; // tg_akhr
        $values[9] = ''; // tx_ref1
        $values[10] = ''; // ln_ref1
        $values[11] = ''; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = '0000-00-00'; // tg_aprv
        $values[14] = ''; // fl_apr2
        $values[15] = '0000-00-00'; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = '0000-00-00'; // tg_ubah
        $values[19] = ''; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 6
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '6'; // no_rutp
        $values[6] = 'SUBMIT REV DRAFT PSAK'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = '0000-00-00'; // tg_akhr
        $values[9] = ''; // tx_ref1
        $values[10] = ''; // ln_ref1
        $values[11] = ''; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = '0000-00-00'; // tg_aprv
        $values[14] = ''; // fl_apr2
        $values[15] = '0000-00-00'; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = '0000-00-00'; // tg_ubah
        $values[19] = ''; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 7
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '7'; // no_rutp
        $values[6] = 'DOK REV DRAFT FINAL'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = $dok_rev_draft_final; // tx_ref1
        $values[10] = 'https://admin.kka-nurichwan.com/upload/' . $dok_rev_draft_final; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 8
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '8'; // no_rutp
        $values[6] = 'SUBMIT REV DRAFT PSAK'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = ''; // tx_ref1
        $values[10] = ''; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 9
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '9'; // no_rutp
        $values[6] = 'APPROVAL PSAK24'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = $approval_psak24; // tx_ref1
        $values[10] = 'https://admin.kka-nurichwan.com/upload/'. $approval_psak24; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = ''; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // 10
        $values[0] = 'SPS0'; // kd_prsh
        $values[1] = 'SPSJKT'; // kd_kprd
        $values[2] = $tahun; // tx_tahn
        $values[3] = 'PD000' . $get_nomor; // kd_prod
        $values[4] = 'RP2402'; // kd_rutp
        $values[5] = '10'; // no_rutp
        $values[6] = 'DOK FINAL PSAK24'; // tx_rutp
        $values[7] = $converted_tanggal; // tg_awal
        $values[8] = $converted_tanggal; // tg_akhr
        $values[9] = $dok_final_psak24; // tx_ref1
        $values[10] = 'https://admin.kka-nurichwan.com/upload/' . $dok_final_psak24; // ln_ref1
        $values[11] = 'X'; // fl_aprv
        $values[12] = 'X'; // fl_aktv
        $values[13] = $converted_tanggal; // tg_aprv
        $values[14] = 'X'; // fl_apr2
        $values[15] = $converted_tanggal; // tg_apr2
        $values[16] = $converted_tanggal; // tg_buat
        $values[17] = 'GENERATE'; // tx_buat
        $values[18] = $converted_tanggal; // tg_ubah
        $values[19] = 'GENERATE'; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_prod .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_prod = rtrim($sql_q_prod, ', ');

    $update_values[] = "
        `tx_rutp` = VALUES(`tx_rutp`),
        `tg_awal` = VALUES(`tg_awal`),
        `tg_akhr` = VALUES(`tg_akhr`),
        `tx_ref1` = VALUES(`tx_ref1`),
        `ln_ref1` = VALUES(`ln_ref1`),
        `fl_aprv` = VALUES(`fl_aprv`),
        `fl_aktv` = VALUES(`fl_aktv`),
        `tg_aprv` = VALUES(`tg_aprv`),
        `fl_apr2` = VALUES(`fl_apr2`),
        `tg_apr2` = VALUES(`tg_apr2`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_prod .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_prod...\n";

    if ($conn->query($sql_q_prod) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_prod\n\n";
    } else {
        echo "Error: " . $sql_q_prod . "<br>" . $conn->error;
    }
}
