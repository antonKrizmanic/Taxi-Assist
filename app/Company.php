<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];
    protected $fillable=[
        'name',
        'startPrice',
        'freeKm',
        'kmPrice',
        'waitingPrice'
    ];

    /**
     * Returns company orders
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany('App\Order');
    }

}
