<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Seller;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Validator;

class SellersImport implements OnEachRow, WithHeadingRow, WithCustomCsvSettings, SkipsEmptyRows, WithChunkReading
{

    /**
     * @param string $delimiter
     */
    public function     __construct(
        protected string $delimiter = ';'
    ){}

    /**
     * @return string[]
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => $this->delimiter
        ];
    }

    /**
     * @param Row $row
     */
    public function onRow(Row $row)
    {
        try {

            // $rowIndex = $row->getIndex();
            $row      = $row->toArray();

            $this->validate($row);

            Seller::insertOrIgnore([
                'id'          => $row['seller_id'],
                'uuid'        => $row['uuid'],
                'firstname'   => $row['seller_firstname'],
                'lastname'    => $row['seller_lastname'],
                'lastname'    => $row['seller_lastname'],
                'date_joined' => $row['date_joined'],
                'country'     => $row['country'],
            ]);

            $contact = Contact::firstOrCreate(
                [
                    'seller_id'    => $row['seller_id'],
                    'fullname'     => $row['contact_customer_fullname'],
                    'region'       => $row['contact_region'],
                    'contact_type' => $row['contact_type'],
                    'date'         => $row['contact_date'],
                ]
            );

            if (!empty($row['sale_net_amount']) && !empty($row['sale_gross_amount']) && !empty($row['sale_tax_rate'])
                && !empty($row['sale_product_total_cost'])) {

                $contact->sales()->firstOrCreate(
                    [
                        'product_type_offered_id' => $row['contact_product_type_offered_id'],
                        'product_type_offered'    => $row['contact_product_type_offered'],
                        'sale_net_amount'         => $row['sale_net_amount'],
                        'sale_gross_amount'       => $row['sale_gross_amount'],
                        'sale_tax_rate'           => $row['sale_tax_rate'],
                        'sale_product_total_cost' => $row['sale_product_total_cost'],
                    ]
                );
            }
        } catch (\Exception $e) {
            // Handle log validation errors
        }
    }

    /**
     * @param array $row
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $row)
    {
        Validator::make($row, [
            'uuid'                            => 'required|string|filled',
            'seller_id'                       => 'required|numeric|min:0',
            'seller_firstname'                => 'required|string|filled',
            'seller_lastname'                 => 'required|string|filled',
            'date_joined'                     => 'required|date_format:Y-m-d',
            'country'                         => 'required|string|filled',
            'contact_region'                  => 'required|string|filled',
            'contact_date'                    => 'required|date_format:Y-m-d',
            'contact_customer_fullname'       => 'required|string|filled',
            'contact_type'                    => 'required|string|filled',
            'contact_product_type_offered_id' => 'required|numeric|min:0',
            'contact_product_type_offered'    => 'required|string|filled',
            'sale_net_amount'                 => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sale_gross_amount'               => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sale_tax_rate'                   => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sale_product_total_cost'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        ])->validate();
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
