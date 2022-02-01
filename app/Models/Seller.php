<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Seller extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sellers';

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
        'id',
        'uuid',
        'firstname',
        'lastname',
        'date_joined',
        'country',
    ];

    /**
     * Get the contacts for the seller.
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function getSellerAllSales(int $id): ?array
    {
        return DB::table('sellers')
            ->join('contacts', 'sellers.id', '=', 'contacts.seller_id')
            ->join('sales', 'contacts.id', '=', 'sales.contact_id')
            ->select('sales.*')
            ->where('sellers.id', '=', $id)
            ->get()->toArray();
    }

}
