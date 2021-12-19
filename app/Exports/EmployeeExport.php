<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
            'First Name',
            'Last Name',
            'Company Name',
            'Email',
            'Department',
            'Phone',
            'Staff_id',
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

            $data = Employee::join('companies', 'employees.company_id', '=', 'companies.id')
                ->where('employees.status', 1)
                ->where('employees.first_name', 'like', '%' . $search . '%')
                ->select('employees.*', 'companies.name')
                ->orWhere('employees.last_name', 'like', '%' . $search . '%')
                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
                ->orWhere('employees.department', 'like', '%' . $search . '%')
                ->orWhere('employees.staff_id', 'like', '%' . $search . '%')
                ->orWhere('companies.name', 'like', '%' . $search . '%')
                ->orderBy('employees.created_at', 'desc')
                ->get();
        } else {
            $data = Employee::where('status', 1)->orderBy('created_at', 'desc')
                ->get();
        }
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->first_name,
            $data->last_name,
            $data->company->name,
            $data->email,
            $data->department,
            $data->phone,

            $data->staff_id,
            $data->address,
            $data->created_at,
            $data->updated_at,

        ];
    }
}
