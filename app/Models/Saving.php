<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $table = "savings",$fillable = ["pemasukan", "pengeluaran", "deskripsi", "user_id", "tanggal", "minggu_ke"], $guarded = [];
}
