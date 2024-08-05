<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkUser extends Model
{
    use HasFactory;

    protected $table = 'homework_user';
    protected $fillable = ['homework_id', 'user_id', 'file', 'nilai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
