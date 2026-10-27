<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionThread extends Model
{
    /**
     * 質問掲示板の質問スレッドのモデル
     * 資格-質問は1-1の関係
     * ユーザー-質問は1-他の関係
     */
    protected $fillable =
    [
        'id',
        'certification_id',
        'user_id',
        'is_resolved',
        'title',
        'body',
    ];

    public function certification(){
        return $this->belongsTo(Certification::class);
    }

    public function users(){
        return $this->HasMany(User::class);
    }

}
