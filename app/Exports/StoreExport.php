<?php

namespace App\Exports;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoreExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Store::select("name", "phone", "address", "city", 'state', 'zip', 'country', 'latitude', 'longitude')->get();
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
