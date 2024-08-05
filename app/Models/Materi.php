<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    /**
     * guarded
     *
     * @var array
     */
    protected $guarded = [];

    protected $table = 'materis';

    public function getLink($id){
        return $this->where('id',$id)->value('link');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel', 'mapel');
    }
}
