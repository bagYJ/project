<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    public function findForOrder($key, $value)
    {
        return DB::table('order')
            ->where($key, $value)
            ->get();
    }
}
