<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving as ModelsSaving;
use Illuminate\Support\Facades\Auth;
class General extends Controller
{
    private $total_pemasukan, $total_pengeluaran;

    public function __construct()
    {
        $this->table = new ModelsSaving();
    }

    public function home() 
    {
        // Menyeleksi table menurut id nya
        $tables_data = $this->table->where("user_id", "=", Auth::user()->id);
        
        // Mendapatkan total pemasukan dan pengeluaran
        $T_pemasukan = $tables_data->sum("pemasukan");
        $T_pengeluaran = $tables_data->sum("pengeluaran");
    
        // Looping untuk menghitung total pemasukan dan pengeluaran mingguan
        for($i = 1; $i <= 4; $i++) {

         $weeks_data_get_week = $tables_data->get(["pemasukan", "pengeluaran", "minggu_ke"]);
         $weeks_data_get_all = $weeks_data_get_week->where("minggu_ke", "=", "$i");
        
        //  Pendeklarasian variabel untuk menghitung total pemasukan & pengeluaran mingguan
        $pemasukan = 0;
        $pengeluaran = 0;
        foreach ($weeks_data_get_all as $data) 
        {
            $pemasukan += $data->pemasukan;
            $pengeluaran += $data->pengeluaran;
            switch ($i) {
                case 1 :
                    $minggu1 = [
                        "pemasukan" => $pemasukan, 
                        "pengeluaran" => $pengeluaran
                    ];
                    break;
                case 2 :
                    $minggu2 = [
                        "pemasukan" => $pemasukan, 
                        "pengeluaran" => $pengeluaran
                    ];
                    break;
                case 3 :
                    $minggu3 = [
                        "pemasukan" => $pemasukan, 
                        "pengeluaran" => $pengeluaran
                    ];
                    break;
                case 4 :
                    $minggu4 = [
                        "pemasukan" => $pemasukan, 
                        "pengeluaran" => $pengeluaran
                    ];
                    break;
             }

         }
        }

        // Nilai undefined untuk variable yang tidak ada isinya
        $nilai_undefined = [
            "pemasukan" => 0,
            "pengeluaran" => 0
        ];

        // Pengecekan nilai week, apakah kosong atau ada isinyaa, lalu masukan nilainya ke aray untuk dikirim nanti
        $arr_all_weeks = [
            $minggu1_valid = !isset($minggu1) ? $nilai_undefined : $minggu1, 
            $minggu2_valid = !isset($minggu2) ? $nilai_undefined : $minggu2, 
            $minggu3_valid = !isset($minggu3) ? $nilai_undefined : $minggu3, 
            $minggu4_valid = !isset($minggu4) ? $nilai_undefined : $minggu4, 
        ];

        // Ini adalah presentase selisih antara pemasukan dan pengeluaran
        $sepuluh_persen = ($T_pemasukan + $T_pengeluaran) * 0.10;

        $rugiORlaba = $T_pemasukan > $T_pengeluaran ? $T_pemasukan - $T_pengeluaran : $T_pengeluaran - $T_pemasukan; // pem - peng = laba , peng - pem = rugi

        // Kondisi jika data null / kosong, maka $rugiORlaba akan bernilai 0 atau $presentase_selisih bernilai 100 karena $T_pengeluaran nol atau kosong.
        if( $rugiORlaba === 0) {
            $presentase_selisih = "0";
            goto a;
        } else if($T_pengeluaran === 0 || is_null($T_pengeluaran)) {
            $presentase_selisih = 100;
            goto a;
        } else if( $T_pemasukan === 0 || is_null($T_pemasukan)) {
            $presentase_selisih = "-100";
            goto a;
        } 

        $selisih = $rugiORlaba / $T_pemasukan;
        if ($rugiORlaba < $sepuluh_persen) {
            // $angka1 = substr($selisih, 2, 1); // substr dimulai dari index angka 0 ..
            // $angka2 = substr($selisih, 3, 1);
            // Mengubah sebuah string menjadi angka 
            // $selisih_total = $angka1 . "." . $angka2;
            $selisih_total = round($selisih, 2);
        } else {
            // Jika hasil dari $selisih adalh > 1 , maka bernilai bilangan asli, maka bagi hasilnya dengan 100 agar menjadi biangan koma
            if( $selisih > 1 ) {
                // Kalikan 10 agar menjadi bilangan puluhan
                $kali10 = $selisih * 10;
                // Jika ada koma nya maka bulatkan dengan 2 angka dibelakang koma
                $selisih_total = round($kali10, 2);
            } else {
                // Namun jika $selisih < 1 maka kali dengan 100 agar menjadi bilangan aslii
                $selisih *= 100;
                // Jika selisih setelah dikalikan bernilai genap, maka langusng eksekusi
                if (substr ("$selisih", 3,1) !== 0) {
                    $selisih_total = round($selisih);
                } else if( is_float($selisih)  ) { 
                    // namun jika selisih setelah dikalikan masih ada komanya, maka akan di filter terlebih dahulu
                    $angka1 = substr("$selisih", 0,1);
                    $angka2 = substr("$selisih", 1,1);
                    // -------------------------------- //
                    $angka3 = substr("$selisih", 3,1);
                    $angka4 = substr("$selisih", 4,1);
                    $selisih_total = $angka1 . $angka2 . "." . $angka3 . $angka4;
                 } 
            }
        }
        
        // Menghitung nilai yang akan di kirim, apakah minus atau tidak
        $presentase_selisih = $T_pemasukan < $T_pengeluaran  ? "-" . $selisih_total : $selisih_total;

        a : // ini adalah variabel dari goto, berfungsi untuk melompati baris kode
        return view("tabungan.home", compact("T_pemasukan", "T_pengeluaran", "arr_all_weeks", "presentase_selisih"));
    }
}
