<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answre extends Model
{
    /**
     * 質問掲示板のスレッドに対する回答スレッド
     * 
     * 回答-ユーザーは1対1の関係
     * 回答-スレッドは多対1の関係
     */
    use HasFactory;
    protected $fillable =
    [
        'id',
        'user_id',
        'thread_id',
        'body',
    ];

    public function user(){
        return this->belongsTo(User::class);
    }

    public function questionthreads(){
        return this->hasMany(QuestionThread::class);
    }
}
