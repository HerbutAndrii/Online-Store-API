<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index() {
        return CompanyResource::collection(Company::orderByDesc('updated_at')->get());
    }

    public function show(Company $company) {
        return new CompanyResource($company);
    }

    public function store(CompanyRequest $request) {
        $company = Company::create(['name' => $request->name]);

        return [
            'status' => 'Company was created successfully',
            'company' => new CompanyResource($company)
        ];
    }

    public function update(CompanyRequest $request, Company $company) {
        $company->update(['name' => $request->name]);

        return [
            'status' => 'Company was updated successfully',
            'company' => new CompanyResource($company)
        ];
    }

    public function destroy(Company $company) {
        $company->delete();

        return ['status' => 'Company was deleted successfully'];
    }
}
