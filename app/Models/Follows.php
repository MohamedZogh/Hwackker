<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    use HasFactory;

    protected $fillable = ['follower_id', 'followed_id'];

    public function scopeHasPrivateAccess($follower, $followed){
        $query = Follows::where([['follower_id', '=', $follower->id], ['followed_id', '=', $followed->id]]);

        if ($query->isEmpty()){
            return false;
        }
        $query = Follows::where([['follower_id', '=', $followed->id], ['followed_id', '=', $follower->id]]);
        $query->isEmpty() ? $check = false: $check = true;

        return $check;
    }
}
