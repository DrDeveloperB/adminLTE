<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po_list extends Model
{
    use HasFactory;
    protected $connection = 'morningletters';
    protected $table = 'po_list';
    protected $primaryKey = 'po_idx';

    public $timestamps = false;
}
