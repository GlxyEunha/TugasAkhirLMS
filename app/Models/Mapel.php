<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';
    protected $fillable = ['mapel'];

    public function materis()
    {
        return $this->hasMany(Materi::class, 'mapel', 'mapel');
    }

}
