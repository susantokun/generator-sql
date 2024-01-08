<?php
include('db_connection.php');

function run_insert_q_sorb($data, $conn, $tahun)
{
    $sql_q_sorb = "INSERT INTO `q_sorb` (
        `kd_prsh`,
        `tp_bill`,
        `tx_tahn`,
        `kd_bill`,
        `tx_bill`,
        `kd_cust`,
        `kd_cusb`,
        `kd_ekst`,
        `nl_bill`,
        `nl_bilp`,
        `tx_kurs`,
        `tg_bill`,
        `fl_part`,
        `fl_aprv`,
        `tx_fakp`,
        `kd_sord`,
        `kd_dord`,
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
        $no_invoice = $row[5] ?? "";
        $harga = floatval(str_replace(',', '', $row[3]));
        $no_faktur = $row[4] ?? "";

        $tx_mtra = $row[0];
        $get_kd_mtra = "";
        $get_mtra_query = "SELECT kd_mtra FROM m_mtra WHERE tx_mtra = '$tx_mtra'";
        $get_mtra_result = $conn->query($get_mtra_query);

        if ($get_mtra_result->num_rows > 0) {
            $get_kd_mtra = $get_mtra_result->fetch_assoc()['kd_mtra'];
        }

        $kd_prsh = 'SPS0';
        $tp_bill = 'SB01';
        $tx_tahn = $tahun;
        $kd_bill = 'SB' . $get_padded;
        $tx_bill = 'GENERATE';
        $kd_cust = $get_kd_mtra;
        $kd_cusb = $get_kd_mtra;
        $kd_ekst = $no_invoice;
        $nl_bill = $harga;
        $nl_bilp = $harga;
        $tx_kurs = 'IDR';
        $tg_bill = $converted_tanggal;
        $fl_part = 'X';
        $fl_aprv = 'X';
        $tx_fakp = $no_faktur;
        $kd_sord = 'SD' . $get_padded;
        $kd_dord = 'PD' . $get_padded;
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $tp_bill, // tp_bill
            $tx_tahn, // tx_tahn
            $kd_bill, // kd_bill
            $tx_bill, // tx_bill
            $kd_cust, // kd_cust
            $kd_cusb, // kd_cusb
            $kd_ekst, // kd_ekst
            $nl_bill, // nl_bill
            $nl_bilp, // nl_bilp
            $tx_kurs, // tx_kurs
            $tg_bill, // tg_bill
            $fl_part, // fl_part
            $fl_aprv, // fl_aprv
            $tx_fakp, // tx_fakp
            $kd_sord, // kd_sord
            $kd_dord, // kd_dord
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorb .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sorb = rtrim($sql_q_sorb, ', ');

    $update_values[] = "
        `tx_bill` = VALUES(`tx_bill`),
        `kd_cust` = VALUES(`kd_cust`),
        `kd_cusb` = VALUES(`kd_cusb`),
        `kd_ekst` = VALUES(`kd_ekst`),
        `nl_bill` = VALUES(`nl_bill`),
        `nl_bilp` = VALUES(`nl_bilp`),
        `tx_kurs` = VALUES(`tx_kurs`),
        `tg_bill` = VALUES(`tg_bill`),
        `fl_part` = VALUES(`fl_part`),
        `fl_aprv` = VALUES(`fl_aprv`),
        `tx_fakp` = VALUES(`tx_fakp`),
        `kd_sord` = VALUES(`kd_sord`),
        `kd_dord` = VALUES(`kd_dord`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_sorb .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sorb...\n";

    if ($conn->query($sql_q_sorb) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sorb\n\n";
    } else {
        echo "Error: " . $sql_q_sorb . "<br>" . $conn->error;
    }
}
