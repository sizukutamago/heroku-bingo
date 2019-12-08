<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public $timestamps = false;
    protected $fillable = ['username', 'room_id'];

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
