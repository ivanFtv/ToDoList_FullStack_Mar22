<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'expiring_date',
        'completed',
        'image'
    ];

    public function getHumanDateAttribute() {
        return Carbon::parse($this->expiring_date)->diffForHumans();
    }
}
