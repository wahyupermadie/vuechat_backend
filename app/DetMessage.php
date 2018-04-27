<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetMessage extends Model
{
    protected $table = "det_messages";
    protected $fillable = [
        'messages', 'message_id', 'user_id',
    ];
    public function user() {
        return $this->belongsTo('App\User');
    }
}
