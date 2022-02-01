<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Sale extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales';

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
        'contact_id',
        'product_type_offered_id',
        'product_type_offered',
        'sale_net_amount',
        'sale_gross_amount',
        'sale_tax_rate',
        'sale_product_total_cost',
    ];

    /**
     * Get the contact.
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }

    /**
     * @param int $year
     * @return array|null
     */
    public static function getSalesListPerYear(int $year): ?array
    {
        return DB::table('sales')
            ->join('contacts', 'contacts.id', '=', 'sales.contact_id')
            ->select('sales.*')
            ->where(DB::raw('YEAR(contacts.date)'), '=', $year)
            ->get()->toArray();
    }

    /**
     * @param int $year
     * @return array|null
     */
    public static function getAmountDataPerYear(int $year): ?array
    {
        $data = (array) DB::table('sales')
            ->join('contacts', 'contacts.id', '=', 'sales.contact_id')
            ->select(
                DB::raw('IFNULL(SUM(sales.sale_net_amount), 0) AS netAmount'),
                DB::raw('IFNULL(SUM(sales.sale_gross_amount), 0) AS grossAmount'),
                DB::raw('IFNULL(SUM(sales.sale_tax_rate), 0) AS taxAmount'),
            )
            ->where(DB::raw('YEAR(contacts.date)'), '=', $year)
            ->first();

        $data['profit'] = number_format($data['grossAmount'] - $data['netAmount'] - $data['taxAmount'], 2);

        return $data;
    }
}
