<?php

namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnquiryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;
        $enquiries = Enquiry::select("name", "gender", "email", "contact_no", "country", "state", "address", "store_name", "store_location", "store_country", "created_at");

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $enquiries->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        }
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $enquiries->where(function ($query) use ($searchKey) {
                $query->where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%')->orWhere('contact_no', 'LIKE', '%' . $searchKey . '%')->orWhere('address', 'LIKE', '%' . $searchKey . '%');
            });
        }
        if (auth()->guard('admin')->user()->role_id == 3) {
            $enquiries->where('store_id', auth()->guard('admin')->user()->store_id);
        } else {
            if ($request->filled('store')) {
                $store_id = $request->query('store');
                $enquiries->where('store_id', $store_id);
            }
        }

        return $enquiries->get();
    }

    public function headings(): array
    {
        return ["Name", "Gender", "Email", "Contact No.", "Country", "State", "Address", "Store Name", "Store Location", "Store Country", "Date"];
    }
}
