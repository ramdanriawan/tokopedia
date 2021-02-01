<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekrutmen extends Model
{
    use HasFactory;

    protected $table = 'rekrutmen';
    protected $guarded = [];
    public $timestamps = false;

    public function __destruct()
    {

        $this->table = strtolower($this->table);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $model->no_pendaftar = IdGenerator::generate(['table' => $model->table, 'field' => 'no_pendaftar', 'length' => 7, 'prefix' => 'P']);
        });
    }
    
}