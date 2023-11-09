<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VehicleController extends Controller
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
        $vehicles = Vehicle::paginate(10);

        return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carBrands = CarBrand::all();
        $carModels = CarModel::all();

        return view('vehicles.create', [
            'carBrands' => $carBrands,
            'carModels' => $carModels
        ]);
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
            'car_brand_id',
            'car_model_id',
            'year',
            'mileage',
            'price',
            'image'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'car_brand_id' => ['required', 'integer'],
            'car_model_id' => ['required', 'integer'],
            'year' => ['required', 'string'],
            'mileage' => ['required'],
            'price' => ['required'],
            'image' => ['required', 'file', 'max:2048', 'mimes:jpeg,jpg,png']
        ], [
            'name.required' => 'Campo Nome é obrigatório',
            'car_brand_id.required' => 'Campo Marca é obrigatório',
            'car_model_id.required' => 'Campo Modelo é obrigatório',
            'year.required' => 'Campo Ano é obrigatório',
            'mileage.required' => 'Campo Quilometragem é obrigatório',
            'price.required' => 'Campo preço é obrigatório',
            'image.required' => 'Campo imagem é obrigatório',
            'image.mimes' => 'A imagem deve ser com extensão jpg, jpeg ou png',
            'image.max' => 'A imagem deve ter no máximo 2MB'
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicles.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Captura o file do post
        $image = $request->file('image');

        // Nome do arquivo é composto por ano, mês, dia, hora, minuto, segundo com o nome do veículo
        $fileName = date('YmdHis') . '-' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();

        // Realiza o upload na pasta app/images
        $image->storeAs('images', $fileName);

        $vehicle = new Vehicle();
        $vehicle->name = $data['name'];
        $vehicle->car_brand_id = $data['car_brand_id'];
        $vehicle->car_model_id = $data['car_model_id'];
        $vehicle->year = $data['year'];
        $vehicle->mileage = str_replace(['.'], [''], $data['mileage']);
        $vehicle->image = $fileName;

        // Convertendo valor de PT-br para USD para incluir no banco
        $inputPrice = str_replace(['.', ','], ['', '.'], $data['price']);
        $price = (float) $inputPrice;
        $vehicle->price = $price;

        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            return view('vehicles.show', ['vehicle' => $vehicle]);
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
        $vehicle = Vehicle::find($id);
        $carBrands = CarBrand::all();
        $carModels = CarModel::all();

        if ($vehicle) {
            return view('vehicles.edit', [
                'vehicle' => $vehicle,
                'carBrands' => $carBrands,
                'carModels' => $carModels
            ]);
        }

        return view('vehicles.index');
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
        $data = $request->only([
            'name',
            'car_brand_id',
            'car_model_id',
            'year',
            'mileage',
            'price',
            'image'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'car_brand_id' => ['required', 'integer'],
            'car_model_id' => ['required', 'integer'],
            'year' => ['required', 'string'],
            'mileage' => ['required'],
            'price' => ['required'],
            'image' => ['file', 'max:2048', 'mimes:jpeg,jpg,png']
        ], [
            'name.required' => 'Campo Nome é obrigatório',
            'car_brand_id.required' => 'Campo Marca é obrigatório',
            'car_model_id.required' => 'Campo Modelo é obrigatório',
            'year.required' => 'Campo Ano é obrigatório',
            'mileage.required' => 'Campo Quilometragem é obrigatório',
            'price.required' => 'Campo preço é obrigatório',
            'image.mimes' => 'A imagem deve ser com extensão jpg, jpeg ou png',
            'image.max' => 'A imagem deve ter no máximo 2MB'
        ]);

        $vehicle = Vehicle::find($id);
        if ($validator->fails()) {
            return redirect()->route('vehicles.edit', ['vehicle' => $vehicle->id])
                ->withErrors($validator)
                ->withInput();
        }

        // Captura o file do post
        $image = $request->file('image');
        // se a imagem conter um arquivo, realiza as verificações, remove o arquivo antigo e inclui um novo
        if ($image) {
            // Nome do arquivo é composto por ano, mês, dia, hora, minuto, segundo com o nome do veículo
            $fileName = date('YmdHis') . '-' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();

            // Realiza o upload na pasta app/images
            $image->storeAs('images', $fileName);

            // Verifica se o arquivo novo foi enviado corretamente.
            if (Storage::disk('images')->exists($fileName)) {
                // Verifica se o arquivo antigo existe na pasta app/images
                $oldfile = $vehicle->image;
                if (Storage::disk('images')->exists($oldfile)) {
                    // Caso exista, remove o mesmo para manter somente um arquivo por veículo
                    Storage::disk('images')->delete($oldfile);
                }
            }

            $vehicle->image = $fileName;
        }

        $vehicle->name = $data['name'];
        $vehicle->car_brand_id = $data['car_brand_id'];
        $vehicle->car_model_id = $data['car_model_id'];
        $vehicle->year = $data['year'];
        $vehicle->mileage = str_replace(['.'], [''], $data['mileage']);

        // Convertendo valor de PT-br para USD para incluir no banco
        $inputPrice = str_replace(['.', ','], ['', '.'], $data['price']);
        $price = (float) $inputPrice;
        $vehicle->price = $price;

        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        // Verifica se o arquivo antigo existe na pasta app/images
        $image = $vehicle->image;
        if (Storage::disk('images')->exists($image)) {
            // Caso exista, remove o arquivo, pois já não será mais utilizado
            Storage::disk('images')->delete($image);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Veículo excluído com sucesso.');
    }
}
