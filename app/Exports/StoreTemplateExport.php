<?php

namespace App\Exports;

use App\Models\Store;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoreTemplateExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([
            [
                'name' => 'Sample Store',
                'phone' => '1234567890',
                'address' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'country' => 'USA',
                'latitude' => '40.7128',
                'longitude' => '-74.0060',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Address',
            'City',
            'State',
            'ZIP',
            'Country',
            'Latitude',
            'Longitude',
        ];
    }
}
