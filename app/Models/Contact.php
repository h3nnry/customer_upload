<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seller_id',
        'fullname',
        'region',
        'contact_type',
        'date',
    ];

    /**
     * Get the seller.
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    /**
     * Get the orders for the contact.
     */
    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }

}
