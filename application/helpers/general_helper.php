<?php

/**
 * change date format from dd/mm/yyyy become yyyy-mm-dd
 * @param <type> $date
 * @return string
 */
function backend_date($date) {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
    {
        return $date;
    }else{
        list($day, $month, $year) = explode('/', $date);
        $new_date = $year . "-" . $month . "-" . $day;
        return $new_date;
    }
    
}

/**
 * change date format from yyyy-mm-dd become dd/mm/yyyy
 * @param <type> $date
 * @return string
 */
function frontend_date($date) {
    list($year, $month, $day) = explode('-', $date);
    $new_date = $day . "/" . $month . "/" . $year;
    return $new_date;
}

/**
 * create money value in Rupiah
 * @param <type> $uang
 * @return <type>
 */
function format_rupiah($uang) {
    return "Rp. " . number_format($uang, 0, ",", ".");

//    if ($uang >= 0) {
//        return 'Rp ' . number_format($uang, 0, ',', '.');
//    } else {
//        return 'Rp -' . number_format(abs($uang), 0, ',', '.');
//    }
}

function format_dana($uang) {
    return number_format($uang, 0, ".", "");
}

function val_decimal($angka) {
    $angka2=(preg_replace("/,/","",$angka));
    return floatval(preg_replace("/^[^0-9\.]/","",$angka2));
}

function indonesian_month($month) {
    switch ($month) {
        case 1 : $imonth = "Januari";
            break;
        case 2 : $imonth = "Februari";
            break;
        case 3 : $imonth = "Maret";
            break;
        case 4 : $imonth = "April";
            break;
        case 5 : $imonth = "Mei";
            break;
        case 6 : $imonth = "Juni";
            break;
        case 7 : $imonth = "Juli";
            break;
        case 8 : $imonth = "Agustus";
            break;
        case 9 : $imonth = "September";
            break;
        case 10 : $imonth = "Oktober";
            break;
        case 11 : $imonth = "November";
            break;
        case 12 : $imonth = "Desember";
            break;
        default : $imonth = "-";
            break;
    }
    return $imonth;
}

/**
 * change date format to indonesia
 * @param <type> $month
 * @return string
 */
function indonesian_date($date) {
    list($year, $month, $day) = explode('-', $date);
    $new_date = $day . " " . indonesian_month((int)$month) . " " . $year;
    return $new_date;
}

function indonesian_yearmonth($yearmonth) {
    list($month, $year) = explode(' ', $yearmonth);
    $new_yearmonth = indonesian_month($month) . " " . $year;
    return $new_yearmonth;
}

function bulan_hari($day) {
    $tahun = floor($day / 365);
    $bulan = floor(($day - ($tahun * 365)) / 30);
    $hari = $day - $bulan * 30;
    if ($day == "30") {
        return $bulan . " Bulan ";
    } elseif ($day >= "30") {
        return $bulan . " Bulan, " . $hari . " Hari";
    } else {
        return $hari . " Hari";
    }
}
