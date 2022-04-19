<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message; // 追加

class Comment extends Model
{
    protected $fillable = ['message_id', 'name', 'body'];
    
    // このコメントに紐づく投稿を取得するメソッド
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
