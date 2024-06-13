<?php

namespace App\Models;

//(import) class Model dari namespace   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//mewarisi yang diimpor sebelumya
class InboundStuff extends Model
{
    use SoftDeletes;
    //ngedefinisiin properti, yang diisi field dibawah
    protected $fillable = ["stuff_id", "total", "date", "proff_file"];

    //stuff yang nerima parameter, buat ngedefeiniskan relasi antara inbound dan stuff
    public function stuff()
    {
        //ngembaliin hasil
        return $this->belongsTo(Stuff::class);
    }
}
