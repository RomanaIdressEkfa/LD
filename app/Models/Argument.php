<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Argument extends Model {
    use HasFactory;
    protected $fillable = [
        'debate_id', 
        'user_id', 
        'side', 
        'body', 
        'parent_id', 
        'reply_type' 
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
    public function replies() {
        return $this->hasMany(Argument::class, 'parent_id')->with(['user', 'votes', 'replies']);
    }
    
    // Helper to count votes
    public function score() {
        return $this->votes()->where('type', 'agree')->count() - $this->votes()->where('type', 'disagree')->count();
    }
}
