<?php
    //Helper untuk menampilkan format jumlah uang contoh 1000000 > 1.000.000
    function money_format ($number) {
        return number_format($number, 0, ',', '.');
    }

    //Helper untuk menampilkan angka terbilang (counted)
    function counted ($number) {
        $number = abs($number);
        $read = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
        $counted = '';

        // if($number < 12){
        //     $counted = ' ' . $read[$number];
        // }

        // return $counted;

        if ($number < 12)               $counted = '' . $read[$number]; //1 - 11
        elseif($number < 20)            $counted = counted($number - 10) . ' belas'; //12 - 19
        elseif($number < 100)           $counted = counted($number / 10) . ' puluh ' . counted($number % 10); //20 - 99
        elseif($number < 200)           $counted = 'seratus ' . counted($number - 100); //100 - 199
        elseif($number < 1000)          $counted = counted($number / 100) . ' ratus ' . counted($number % 100);//200 - 999
        elseif($number < 2000)          $counted = 'seribu ' . counted($number - 1000); //1.000 - 1.999
        elseif($number < 1000000)       $counted = counted($number / 1000) . ' ribu ' . counted($number % 1000); //2.000 - 999.999
        elseif($number < 1000000000)    $counted = counted($number / 1000000) . ' juta ' . counted($number % 1000000); //1.000.000 - 999.999.999
        
        return $counted;
    }

    //Helper untuk format tanggal di Indonesia
    // 2023-08-08
    // ^^^^ ^^ ^^
    // 1234 56 78 urutan formatnya

    function indonesian_date($date, $show_day = true) {
        $day_name   = array (
            'Senin' , 'Selasa' , 'Rabu' , 'Kamis' , 'Jumat' , 'Sabtu' , 'Minggu'
        );
        $month_name = array (1 =>
            'Januari' , 'Februari' , 'Maret' , 'April' , 'Mei' , 'Juni' , 'Juli' , 'Agustus' , 'September' , 'Oktober' , 'November' . 'Desember'
        );

        $year  = substr($date, 0, 4);
        $month = $month_name[(int) substr($date, 5, 2)];
        $date  = substr($date, 8, 2);
        $text  = '';

        if ($show_day) {
            $day_order = date('w', mktime(0,0,0, (int) substr($date, 5, 2), $date, $year));
            $day       = $day_name[$day_order];
            $text     .= "$day, $date $month $year"; 
        }else {
            $text     .= "$date $month $year";
        }

        return $text;
    }

    //Helper untuk menambahkan angka 0 di depan kode produk
    function add_zero_front($value, $threshold = null) {
        return sprintf("%0" . $threshold . "s", $value);
    }

?>