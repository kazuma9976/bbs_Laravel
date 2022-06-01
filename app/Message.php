<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // 入力を検証するメソッドの定義
    public function validate() {
        // エラー配列を空で作成
        $errors = array();
        
        // 名前が入力されていなければ
        if($this->name === null) {
            $errors[] = '名前を入力してください';
        }
        // 内容が入力されていなければ
        if($this->title === null) {
            $errors[] = 'タイトルを入力してください';
        }
        // 内容が入力されていなければ
        if($this->body === null) {
            $errors[] = '内容を入力してください';
        }
        // 画像が選択されていなければ
        if($this->image === null) {
            $errors[] = '画像を選択してください';
        }
        
        // エラー配列を返す
        return $errors;
        
    }
    
    // この投稿に紐づくコメント一覧を取得するメソッド
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
