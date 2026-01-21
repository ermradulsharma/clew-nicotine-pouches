<?php

namespace App\Imports;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Store([
            'name' => $row['name'] ?? '',
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? '',
            'city' => $row['city'] ?? '',
            'state' => $row['state'] ?? '',
            'zip' => $row['zip'] ?? 0,
            'country' => $row['country'] ?? '',
            'latitude' => $row['latitude'] ?? null,
            'longitude' => $row['longitude'] ?? null,
            'status' => 1,
            'filename' => $row['filename'] ?? null,
            'created_by' => Auth::id(),
            'created_at' => now(),
        ]);
    }
}
