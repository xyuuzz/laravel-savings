<?php

namespace App\Http\Controllers;

use App\Models\Saving as ModelsSaving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Saving extends Controller
{
    public $total_pemasukan, $total_pengeluaran;

    public function __construct()
    {
        $this->table = new ModelsSaving();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneys = $this->table->where("user_id", "=", Auth::user()->id)->get(["pemasukan", "pengeluaran"]);
        foreach($moneys as $money) {
            $this->total_pemasukan += $money->pemasukan;
            $this->total_pengeluaran += $money->pengeluaran;
        }
        $T_pemasukan = $this->total_pemasukan;
        $T_pengeluaran = $this->total_pengeluaran;

        $Table = $this->table->where("user_id", "=", Auth::user()->id)->get();
        // Untuk mengambil data tabel tabungan menurut user_id nya
        return view("tabungan.tabungan", compact("Table", "T_pemasukan", "T_pengeluaran"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tabungan.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Tanggal untuk kolom minggu_ke
        $kalender = explode("-" , $request->tanggal);
        // $tanggal = explode("-", $kalender);
        $only_tanggal = end($kalender);
        if( $only_tanggal <= 7 ) {
            $minggu_ke = 1;
        } else if( $only_tanggal <= 14 && $only_tanggal > 7 ) {
            $minggu_ke = 2;
        } else if( $only_tanggal <= 21 && $only_tanggal > 14 ) {
            $minggu_ke = 3;
        } else if ($only_tanggal > 21){
            $minggu_ke = 4;
        }


        // Validation
        $valid = !$request->pemasukan && !$request->pengeluaran ? 'pemasukan' : 'tanggal';
        $desk =  $valid == "pemasukan" ? "Salah Satu Kolom" : "Kolom Tanggal";

        $request->validate([
            'deskripsi' => 'required',
            $valid => 'required'
        ], [
            "deskripsi.required" => "Kolom Deskripsi Wajib diisi!!",
            "$valid.required" => "$desk Wajib diisi"
        ]);

        // Masukan ke dalam table
        $this->table->create([
            "pemasukan" => $request->pemasukan,
            "pengeluaran" => $request->pengeluaran,
            "deskripsi" => $request->deskripsi,
            "tanggal" => $request->tanggal,
            "user_id" => Auth::user()->id,
            "minggu_ke" => $minggu_ke
        ]);

        // beri alert/ pesan bahwa data berhasil dimasukan

        return redirect(route("saving.index"))->with("create", "Data berhasil dibuat!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->table::find($id);   
        return view("tabungan.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = !$request->pemasukan && !$request->pengeluaran ? 'pemasukan' : 'tanggal';
        $desk = $valid == "pemasukan" ? "Salah Satu Kolom" : "Kolom Tanggal";

        $request->validate([
            'deskripsi' => 'required',
            $valid => 'required'
        ], [
            "deskripsi.required" => "Kolom Deskripsi Wajib diisi!!",
            "$valid.required" => "$desk Wajib diisi"
        ]);

        $data = $this->table::find($id)->update([
            "pemasukan"  => $request->pemasukan,
            "pengeluaran" => $request->pengeluaran,
            "deskripsi" => $request->deskripsi,
            "tanggal" => $request->tanggal,
        ]);

return redirect(route("saving.index"))->with("update", "Data Berhasil Di Update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->table::find($id)->delete();
        return redirect( route("saving.index") ) -> with("delete", "Data berhasil Dihapus"); 
    }
}
