<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carModels = CarModel::paginate(10);

        return view('carModels.index', [
            'carModels' => $carModels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carBrands = CarBrand::all();

        return view('carModels.create', ['carBrands' => $carBrands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'car_brand_id'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'car_brand_id' => ['required']
        ], [
            'name.required' => 'Campo Nome é obrigatório',
            'car_brand_id.required' => 'Campo Marca é obrigatório',
        ]);

        if ($validator->fails()) {
            return redirect()->route('carModels.create')
                ->withErrors($validator)
                ->withInput();
        }

        $hasName = CarModel::where('name', $data['name'])->get();

        if (count($hasName) > 0) {
            $validator->errors()->add('name', 'Esse modelo já existe no sistema');
        }

        if (count($validator->errors()) > 0) {
            return redirect()->route('carModels.create')
                ->withErrors($validator)
                ->withInput();
        }

        $carModel = new CarModel();
        $carModel->name = $data['name'];
        $carModel->car_brand_id = $data['car_brand_id'];
        $carModel->save();

        return redirect()->route('carModels.index')->with('success', 'Modelo cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carModel = CarModel::find($id);

        if ($carModel) {
            return view('carModels.show', ['carModel' => $carModel]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carModel = CarModel::find($id);
        $carBrands = CarBrand::all();

        if ($carModel) {
            return view('carModels.edit', ['carModel' => $carModel, 'carBrands' => $carBrands]);
        }

        return view('carModels.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carModel = CarModel::find($id);

        if ($carModel) {

            $data = $request->only([
                'name',
                'car_brand_id'
            ]);

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'car_brand_id' => ['required']
            ], [
                'name.required' => 'Campo Nome é obrigatório',
                'car_brand_id.required' => 'Campo Marca é obrigatório',
            ]);

            if ($validator->fails()) {
                return redirect()->route('carModels.edit', ['carModel' => $carModel->id])
                    ->withErrors($validator);
            }

            if ($carModel->name != $data['name']) {

                $hasName = CarModel::where('name', $data['name'])->get();
                if (count($hasName) === 0) {
                    $carModel->name = $data['name'];
                } else {
                    $validator->errors()->add('name', 'Esse modelo já existe no sistema');
                }
            }

            if (count($validator->errors()) > 0) {
                return redirect()->route('carModels.edit', ['carModel' => $carModel->id])
                    ->withErrors($validator);
            }

            $carModel->car_brand_id = $data['car_brand_id'];
            $carModel->save();
        }

        return redirect()->route('carModels.index')->with('success', 'Modelo alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carModel = CarModel::find($id);

        if ($carModel->vehicles->count() > 0) {
            return redirect()->route('carModels.index')->with('error', 'Não foi possível excluir o modelo, pois ele contém veículos relacionados.');
        }
        $carModel->delete();

        return redirect()->route('carModels.index')->with('success', 'Modelo excluído com sucesso.');
    }

    /**
     * Filter car models by car brand.
     *
     * @param  int  $carBrandId
     * @return Json
     */
    public function getModelsByBrand($carBrandId)
    {
        $models = CarModel::where('car_brand_id', $carBrandId)->pluck('name', 'id')->toArray();
        return response()->json($models);
    }
}
