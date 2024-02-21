<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\ResponseHelper;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SupplierController extends Controller
{
    private $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    private function cleanSupplierData(array $data): array
    {
        $data = array_map('strtoupper', $data);

        if (isset($data['identification'])) {
            $data['identification'] = preg_replace('/[^0-9]/', '', $data['identification']);
        }

        if (isset($data['phone'])) {
            $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
        }
    
        if (isset($data['postal_code'])) {
            $data['postal_code'] = preg_replace('/[^0-9]/', '', $data['postal_code']);
        }

        return $data;
    }

    public function index(Request $request)
    {
        $cacheKey = 'api_supplies_' . md5(json_encode($request->all()));

        if (Cache::has($cacheKey)) {
            $suppliers = Cache::get($cacheKey);
        } else {
            $query = $this->supplier->query();

            if ($request->has('attributes')) {
                $attributesArray = explode(',', $request->get('attributes'));
                $query->select($attributesArray);
            }
            if ($request->has('search')) {
                $search = $request->get('search');
                $query->where(function ($query) use ($search, $attributesArray) {
                    foreach ($attributesArray as $attribute) {
                        $query->orWhere($attribute, 'like', "%$search%");
                    }
                });
            }

            $suppliers = $query->get();

            Cache::put($cacheKey, $suppliers, 60 * 60);
        }
        return ResponseHelper::response(200, 'Fornecedores listados com sucesso.', $suppliers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Define a chave de cache com base no ID do fornecedor
        $cacheKey = 'api_supplies_' . md5(json_encode($id));

        if (Cache::has($cacheKey)) {
            $supplier = Cache::get($cacheKey);
        } else {
            $supplier = $this->supplier->find($id);

            if ($supplier === null) {
                return ResponseHelper::response(404, 'Fornecedor não encontrado.');
            }

            Cache::put($cacheKey, $supplier, 60 * 60);
        }
        

        return ResponseHelper::response(200, 'Fornecedor encontrado com sucesso.', $supplier);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Supplier\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $this->cleanSupplierData($request->validated());

        $supplier = $this->supplier->create($data);

        Cache::flush();

        return ResponseHelper::response(201, 'Fornecedor criado com sucesso.', $supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Supplier\UpdateSupplierRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, int $id)
    {
        $supplier = $this->supplier->find($id);

        if ($supplier === null) {
            return ResponseHelper::response(404, 'Fornecedor não encontrado.');
        }

        $data = $this->cleanSupplierData($request->validated());

        $supplier->update($data);

        Cache::flush();

        return ResponseHelper::response(200, 'Fornecedor atualizado com sucesso.', $supplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $supplier = $this->supplier->find($id);

        if ($supplier === null) {
            return ResponseHelper::response(404, 'Fornecedor não encontrado.');
        }

        $supplier->delete();

        Cache::flush();

        return ResponseHelper::response(200, 'Fornecedor deletado com sucesso.');
    }
}
