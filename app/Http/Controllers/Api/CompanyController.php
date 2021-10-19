<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Company::join('company_statuses', 'companies.id', '=', 'company_statuses.id')
        ->join('users', 'users.id', '=', 'companies.user_id')
        ->where('company_statuses.id', 1);
        if(isset($request->name)){
            $query->where('company_statuses.id', 1);
        }
        if(isset($request->category_id)){
            $query->where('company_statuses.id', 1);
        }
        $query->inRandomOrder();
        $companies = $query->paginate(20);
        return Response()->json(['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = Company::where('name', $request->name)->exists();
        if(!$company){
            $company = new Company;
            $company->name = $request->name;
            $company->user_id = Auth::user()->id;
            $company->category_id = $request->category_id;
            $company->status = 0;
            $response = $company->save();
            if($response)
                return Response()->json(['error' => false, 'message' => 'Empresa criada com sucesso']);
            return Response()->json(['error' => true, 'message' => 'Falha ao criar a sua empresa! Tente novamente.']);

        }

        return Response()->json(['error' => true, 'message' => 'Empresa já existente, tente novamente com outro nome!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $company = Company::join('company_statuses', 'companies.id', '=', 'company_statuses.id')
        ->join('users', 'users.id', '=', 'companies.user_id')
        ->where('company_statuses.id', 1)
        ->where('company.id', $request->id)->first();
        return Response()->json(['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $company = Company::where('name', $request->id)->first();
        if($company){
            $company = new Company;
            $company->name = $request->name;
            $company->category_id = $request->category_id;
            $company->status = $request->status;
            $response = $company->save();
            if($response)
                return Response()->json(['error' => false, 'message' => 'Empresa atualizada com sucesso']);
            return Response()->json(['error' => true, 'message' => 'Falha ao criar a sua empresa! Tente novamente.']);

        }

        return Response()->json(['error' => true, 'message' => 'Empresa não existente!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company = Company::where('name', $request->id)->first();
        if($company){
            Company::destroy($company->id);
            return Response()->json(['error' => false, 'message' => 'Empresa deletada com sucesso']);
        }
        return Response()->json(['error' => true, 'message' => 'Empresa não existente!']);
    }
}
