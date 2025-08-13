<?php
namespace App\Http\Controllers;

use App\materiales_graficos;
use App\tipo_material_grafico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class materialesGraficosController extends Controller
{
    //funcion que obtiene los tipos de materiales gráficos (id y nombre) y los pasa, por medio de la función compact, a la view create.
    public function index()
    {
        $tipos=tipo_material_grafico::all();
        
        return view('admin.materiales_graficos.crear', compact('tipos'));
    }

    //funcion encargada de retornar view create
    public function create()
    {
        return view('materiales_graficos.create');
    }

    //funcion store encargada de guardar los datos de los materiales gráficos en la base de datos
   public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'tipo_material_grafico_id' => 'required|exists:tipo_material_grafico,id',
            'img' => 'required|image|max:2048',
        ]);


        $imgPath = $request->file('img')->store('materiales', 'public');
        
        materiales_graficos::create([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'disponible' => 0,
            'id_tipo_material_grafico' => $request->tipo_material_grafico_id,
            'img' => $imgPath,
        ]);

        
        return redirect()->route('admin.registrar.material.evento')->with('success', 'Material gráfico creado exitosamente.');
    }


    //funcion edit encargada de obtener los datos de los materiales gráficos
    public function edit($id)
    {
        $material = materiales_graficos::findOrFail($id);
        $tipos_materiales = tipo_material_grafico::pluck('nombre', 'id');
        return view('admin.materiales_graficos.editar', compact('material', 'tipos_materiales'));
    }

    //funcion update encargada de actualizar los datos de los materiales gráficos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'tipo_material_grafico_id' => 'required|exists:tipo_material_grafico,id',
            'img' => 'nullable|image|max:2048',
        ]);
        $material = materiales_graficos::findOrFail($id);
        $material->nombre = $request->nombre;
        $material->cantidad = $request->cantidad;
        $material->disponible =  $request->disponible ? 1 : 0;
        $material->id_tipo_material_grafico = $request->tipo_material_grafico_id;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('materiales', 'public');
            $material->img = $imgPath;
        }
        $material->save();

        return redirect()->route('admin.materiales.listar')->with('success', 'Material gráfico actualizado exitosamente.');
       
    }

    //funcion get para obtener los datos de los materiales gráficos
    public function get(){
        $materiales=materiales_graficos::select(
            'materiales_graficos.id',
            'materiales_graficos.nombre',
            'materiales_graficos.cantidad',
            'materiales_graficos.disponible',
            'tipo_material_grafico.nombre as tipo',
            'materiales_graficos.img'
        )
        ->join('tipo_material_grafico', 'materiales_graficos.id_tipo_material_grafico', '=', 'tipo_material_grafico.id')
        ->get();
        return view('admin.materiales_graficos.listar', compact('materiales'));  
    }
}
