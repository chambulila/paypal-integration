<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    protected $expectedColumns = ['name', 'phone', 'email', 'department_id', 'reg', 'password']; 

    public function model(array $row)
    {
        $mappedData = [];
        foreach ($this->expectedColumns as $index => $column) {
            $mappedData[$column] = $row[$column] ?? null;
        }

        return new User([
            'name' => $mappedData['name'],
            'phone' => $mappedData['phone'],
            'email' => $mappedData['email'],
            'department_id' => $mappedData['department_id'],
            'reg' => $mappedData['reg'],
            'password' => Hash::make($mappedData['password'] ?? '123456'),
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Assuming headers are in the first row
    }

    public function onHeadingRow(array $header)
    {
        $diff = array_diff($this->expectedColumns, $header);
        if (!empty($diff)) {
            throw new \Exception('Column names do not match the expected format.');
        }
    }
}
