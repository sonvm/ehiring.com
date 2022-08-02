<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringBoard extends Model
{
    use HasFactory;
    protected $table = 'hiring_board_members';
    public $timestamps=false;
}
