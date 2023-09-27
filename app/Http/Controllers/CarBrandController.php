<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CarBrandController extends Controller
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
        $carBrands = CarBrand::paginate(10);

        return view('carBrands.index', [
            'carBrands' => $carBrands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carBrands.create');
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
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Campo Nome é obrigatório',
        ]);

        if ($validator->fails()) {
            return redirect()->route('carBrands.create')
                ->withErrors($validator)
                ->withInput();
        }

        $hasName = CarBrand::where('name', $data['name'])->get();

        if (count($hasName) > 0) {
            $validator->errors()->add('name', 'Essa marca já existe no sistema');
        }

        if (count($validator->errors()) > 0) {
            return redirect()->route('carBrands.create')
                ->withErrors($validator)
                ->withInput();
        }

        $carBrand = new CarBrand();
        $carBrand->name = $data['name'];
        $carBrand->save();

        return redirect()->route('carBrands.index')->with('success', 'Marca cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carBrand = CarBrand::find($id);

        if ($carBrand) {
            return view('carBrands.show', ['carBrand' => $carBrand]);
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
        $carBrand = CarBrand::find($id);

        if ($carBrand) {
            return view('carBrands.edit', ['carBrand' => $carBrand]);
        }

        return view('carBrands.index');
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
        $carBrand = CarBrand::find($id);

        if ($carBrand) {
            $data = $request->only([
                'name',
            ]);

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
            ], [
                'name.required' => 'Campo Nome é obrigatório',
            ]);

            if ($validator->fails()) {
                return redirect()->route('carBrands.edit', ['carBrand' => $carBrand->id])
                    ->withErrors($validator);
            }

            if ($carBrand->name != $data['name']) {
                $hasName = CarBrand::where('name', $data['name'])->get();
                if (count($hasName) === 0) {
                    $carBrand->name = $data['name'];
                } else {
                    $validator->errors()->add('name', 'Essa marca já existe no sistema');
                }
            }

            if (count($validator->errors()) > 0) {
                return redirect()->route('carBrands.edit', ['carBrand' => $carBrand->id])
                    ->withErrors($validator);
            }

            $carBrand->save();
        }

        return redirect()->route('carBrands.index')->with('success', 'Marca alterada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carBrand = CarBrand::find($id);

        if ($carBrand->carModels->count() > 0) {
            return redirect()->route('carBrands.index')->with('error', 'Não é possível excluir esta marca porque há modelos relacionados a ela.');
        }

        $carBrand->delete();

        return redirect()->route('carBrands.index')->with('success', 'Marca excluída com sucesso.');
    }
}
