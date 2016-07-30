<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    protected $fillable=[
        'startAddress','endAddress','description','company_id','distance','price'
    ];

    /**
     * Returns Company which owns this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo('App\Company');
    }

    /**
     * Returns user which owns this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
