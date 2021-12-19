<?php

namespace App\Exports;

use App\Models\Company\Company;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class CompanyExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{

    use Exportable;

    private $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Company Name',
            'Email',
            'Address',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $search = trim($this->search);



        if ($search) {

            $data = Company::where('status', 1)
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $data = Company::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->name,
            $data->email,
            $data->address,
            $data->created_at,
            $data->updated_at,

        ];
    }
}
