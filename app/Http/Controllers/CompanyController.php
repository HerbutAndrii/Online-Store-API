<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::with('products')->orderByDesc('updated_at')->get();

        return CompanyResource::collection($companies);
    }

    public function show(Company $company) {
        return new CompanyResource($company->load('products'));
    }

    public function store(StoreCompanyRequest $request) {
        $company = new Company($request->only('name', 'description'));
        $company->user()->associate($request->user());
        $company->save();

        return [
            'message' => 'Company was created successfully',
            'company' => new CompanyResource($company)
        ];
    }

    public function update(UpdateCompanyRequest $request, Company $company) {
        $this->authorize('update', $company);

        $company->update([
            'name' => $request->name ?? $company->name,
            'description' => $request->description ?? $company->description
        ]);

        return [
            'message' => 'Company was updated successfully',
            'company' => new CompanyResource($company->load('products'))
        ];
    }

    public function destroy(Company $company) {
        $this->authorize('delete', $company);

        $company->delete();

        return ['message' => 'Company was deleted successfully'];
    }
}
