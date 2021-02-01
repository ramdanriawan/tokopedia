<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $guarded = [];
    public $timestamps = false;

    public function __destruct()
    {

        $this->table = strtolower($this->table);
    }

    public function surat_masuk()
    {
        return $this->belongsTo('App\Models\SuratMasuk');
    }
    
    public function unit_kerja_sub_bagian()
    {
        return $this->belongsTo('App\Models\SubBagian');
    }

    public function rekrutmen_jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan');
    }
    
}