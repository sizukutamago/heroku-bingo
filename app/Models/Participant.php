<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['username'];

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
