<?php
include('db_connection.php');

function run_insert_q_sorh($data, $conn, $tahun)
{
    $sql_q_sorh = "INSERT INTO `q_sorh` (
        `kd_prsh`, 
        `tp_sord`, 
        `tx_tahn`, 
        `kd_sord`, 
        `tx_sord`, 
        `kd_cust`, 
        `kd_cusd`, 
        `ob_stra`, 
        `pr_stra`, 
        `nl_sord`, 
        `nl_base`, 
        `nl_pegt`, 
        `nl_pkwt`, 
        `kd_kurs`, 
        `ob_hrga`, 
        `tx_prde`, 
        `tg_delv`, 
        `tg_sord`, 
        `tx_ref2`, 
        `kd_sinq`, 
        `kd_ekst`, 
        `fl_aprv`, 
        `fl_prod`, 
        `fl_hakh`, 
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
        $get_periode = date("mY", strtotime($converted_tanggal));
        $harga = floatval(str_replace(',', '', $row[3]));
        $no_spk = $row[1] ?? "";
        $file_spk_nama = $tahun . "_" . 'SP' . $get_padded . ".pdf";
        
        $tx_mtra = $row[0];
        $get_kd_mtra = "";
        $get_mtra_query = "SELECT kd_mtra FROM m_mtra WHERE tx_mtra = '$tx_mtra'";
        $get_mtra_result = $conn->query($get_mtra_query);

        if ($get_mtra_result->num_rows > 0) {
            $get_kd_mtra = $get_mtra_result->fetch_assoc()['kd_mtra'];
        }

        $kd_prsh = 'SPS0';
        $tp_sord = 'SP02';
        $tx_tahn = $tahun;
        $kd_sord = 'SP' . $get_padded;
        $tx_sord = 'GENERATE';
        $kd_cust = $get_kd_mtra;
        $kd_cusd = $get_kd_mtra;
        $ob_stra = 'STRA' . $kd_sord;
        $pr_stra = 'STR1';
        $nl_sord = $harga;
        $nl_base = $harga;
        $nl_pegt = $harga;
        $nl_pkwt = '0';
        $kd_kurs = 'IDR';
        $ob_hrga = $kd_sord . 'NORM00';
        $tx_prde = $get_periode;
        $tg_delv = '0000-00-00';
        $tg_sord = $converted_tanggal;
        $tx_ref2 = $file_spk_nama;
        $kd_sinq = $kd_sord;
        $kd_ekst = $no_spk;
        $fl_aprv = 'X';
        $fl_prod = '';
        $fl_hakh = 'X';
        $tg_buat = $converted_tanggal;
        $tx_buat = 'GENERATE';
        $tg_ubah = $converted_tanggal;
        $tx_ubah = 'GENERATE';

        $values = [
            $kd_prsh, // kd_prsh
            $tp_sord, // tp_sord
            $tx_tahn, // tx_tahn
            $kd_sord, // kd_sord
            $tx_sord, // tx_sord
            $kd_cust, // kd_cust
            $kd_cusd, // kd_cusd
            $ob_stra, // ob_stra
            $pr_stra, // pr_stra
            $nl_sord, // nl_sord
            $nl_base, // nl_base
            $nl_pegt, // nl_pegt
            $nl_pkwt, // nl_pkwt
            $kd_kurs, // kd_kurs
            $ob_hrga, // ob_hrga
            $tx_prde, // tx_prde
            $tg_delv, // tg_delv
            $tg_sord, // tg_sord
            $tx_ref2, // tx_ref2
            $kd_sinq, // kd_sinq
            $kd_ekst, // kd_ekst
            $fl_aprv, // fl_aprv
            $fl_prod, // fl_prod
            $fl_hakh, // fl_hakh
            $tg_buat, // tg_buat
            $tx_buat, // tx_buat
            $tg_ubah, // tg_ubah
            $tx_ubah, // tx_ubah
        ];

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorh .= "\n('" . implode("', '", $formattedValues) . "'), ";

        // Baris kedua
        $values[0] = $kd_prsh; // kd_prsh
        $values[1] = 'SD24'; // tp_sord
        $values[2] = $tx_tahn; // tx_tahn
        $values[3] = 'SD' . $get_padded; // kd_sord
        $values[4] = $tx_sord; // tx_sord
        $values[5] = $kd_cust; // kd_cust
        $values[6] = $kd_cusd; // kd_cusd
        $values[7] = 'STRA' . $values[3]; // ob_stra
        $values[8] = $pr_stra; // pr_stra
        $values[9] = $nl_sord; // nl_sord
        $values[10] = $nl_base; // nl_base
        $values[11] = '0'; // nl_pegt
        $values[12] = '0'; // nl_pkwt
        $values[13] = $kd_kurs; // kd_kurs
        $values[14] = $values[3] . 'NORM00'; // ob_hrga
        $values[15] = $tx_prde; // tx_prde
        $values[16] = $tg_delv; // tg_delv
        $values[17] = $tg_sord; // tg_sord
        $values[18] = ''; // tx_ref2
        $values[19] = $kd_sinq; // kd_sinq
        $values[20] = $kd_ekst; // kd_ekst
        $values[21] = $fl_aprv; // fl_aprv
        $values[22] = 'X'; // fl_prod
        $values[23] = ''; // fl_hakh
        $values[24] = $tg_buat; // tg_buat
        $values[25] = $tx_buat; // tx_buat
        $values[26] = $tg_ubah; // tg_ubah
        $values[27] = $tx_ubah; // tx_ubah

        $formattedValues = array_map(function ($value) use ($conn) {
            return $conn->real_escape_string($value);
        }, $values);
        $sql_q_sorh .= "\n('" . implode("', '", $formattedValues) . "'), ";
    }

    $sql_q_sorh = rtrim($sql_q_sorh, ', ');

    $update_values[] = "
        `tx_sord` = VALUES(`tx_sord`),
        `kd_cust` = VALUES(`kd_cust`),
        `kd_cusd` = VALUES(`kd_cusd`),
        `ob_stra` = VALUES(`ob_stra`),
        `pr_stra` = VALUES(`pr_stra`),
        `nl_sord` = VALUES(`nl_sord`),
        `nl_base` = VALUES(`nl_base`),
        `nl_pegt` = VALUES(`nl_pegt`),
        `nl_pkwt` = VALUES(`nl_pkwt`),
        `kd_kurs` = VALUES(`kd_kurs`),
        `ob_hrga` = VALUES(`ob_hrga`),
        `tx_prde` = VALUES(`tx_prde`),
        `tg_delv` = VALUES(`tg_delv`),
        `tg_sord` = VALUES(`tg_sord`),
        `tx_ref2` = VALUES(`tx_ref2`),
        `kd_sinq` = VALUES(`kd_sinq`),
        `kd_ekst` = VALUES(`kd_ekst`),
        `fl_aprv` = VALUES(`fl_aprv`),
        `fl_prod` = VALUES(`fl_prod`),
        `fl_hakh` = VALUES(`fl_hakh`),
        `tg_buat` = VALUES(`tg_buat`),
        `tx_buat` = VALUES(`tx_buat`),
        `tg_ubah` = VALUES(`tg_ubah`),
        `tx_ubah` = VALUES(`tx_ubah`);
    \n";

    $sql_q_sorh .= " \nON DUPLICATE KEY UPDATE " . implode(", ", $update_values);

    echo "Sedang memproses untuk q_sorh...\n";

    if ($conn->query($sql_q_sorh) === TRUE) {
        echo "Data berhasil dimasukkan ke tabel q_sorh\n\n";
    } else {
        echo "Error: " . $sql_q_sorh . "<br>" . $conn->error;
    }
}
