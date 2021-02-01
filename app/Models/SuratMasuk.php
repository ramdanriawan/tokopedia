<?php

namespace App\Models;

use App\Models\User;
use App\Models\Disposisi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $guarded = [];
    public $timestamps = false;

    public function __destruct()
    {

        $this->table = strtolower($this->table);
    }

    public function sifat_surat()
    {
        return $this->belongsTo('App\Models\SifatSurat');
    }

    public function user_unit_kerja()
    {
        return $this->belongsTo(User::class);
    }

    public function disposisi()
    {
        return $this->hasOne(Disposisi::class);
    }
}