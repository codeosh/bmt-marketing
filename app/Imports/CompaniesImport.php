<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Add this line to handle headers in the Excel file

class CompaniesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Company([
            'industry_group' => $row['industry_group'] ?? null,
            'company_name' => $row['company_name'] ?? null,
            'contact_person' => $row['contact_person'] ?? null,
            'contact_number' => $row['contact_number'] ?? null,
            'email' => $row['email'] ?? null,
            'address' => $row['address'] ?? null,
            'other_digi_contact_platform' => $row['other_digi_contact_platform'] ?? null,
            'terms_of_payment' => $row['terms_of_payment'] ?? null,
            'contacted' => $row['contacted'] ?? null,
            'to_recontact' => $row['to_recontact'] ?? null,
            'to_email' => $row['to_email'] ?? null,
            'to_propose' => $row['to_propose'] ?? null,
            'visited' => $row['visited'] ?? null,
            'ec_ordered1' => $row['ec_ordered1'] ?? null,
            'problematic' => $row['problematic'] ?? null,
            'acct_active' => $row['acct_active'] ?? null,
            'notes' => $row['notes'] ?? null,
            'description' => $row['description'] ?? null,
            'status' => $row['status'] ?? 'active', // Default to 'active' if not provided
        ]);
    }
}