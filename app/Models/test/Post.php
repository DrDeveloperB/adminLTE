<?php

namespace App\Models\test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    // 입력 허용할 데이터 필드
    protected $fillable = [
        'title',
        'body',
    ];
}
