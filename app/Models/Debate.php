<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debate extends Model {
    use HasFactory;
    protected $guarded = [];

    public function arguments() {
        return $this->hasMany(Argument::class);
    }

    public function participants() {
        return $this->hasMany(DebateParticipant::class);
    }
    
    public function isFull() {
        if ($this->max_participants === null) return false; 
        return $this->participants()->count() >= $this->max_participants;
    }

    public function spotsLeft() {
        if ($this->max_participants === null) return "Unlimited";
        return $this->max_participants - $this->participants()->count();
    }
}
