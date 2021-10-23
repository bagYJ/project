<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'nickname',
        'password',
        'phone',
        'email',
        'sex',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForUsers($key, $value)
    {
        $order = DB::table('order')
            ->select('orderNo', 'userId', 'orderGoodsNm', 'payed_at')
            ->orderByDesc('id')
            ->limit(1);

        return DB::table('users')
            ->leftJoinSub($order, 'o', function ($join) {
                $join->on('users.id', '=', 'o.userId');
            })
            ->where($key, $value);
//        return $this->where($key, $value);
    }
}
