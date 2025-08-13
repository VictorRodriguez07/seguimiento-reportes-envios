<?php
namespace App\Http\Controllers;
use App\detalle_envio_material;
use App\materiales_graficos;
use App\reporte_envios_evento;
use App\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportesEnviosEventosController extends Controller
{

    //funcion para obtener los reportes de envios de materiales a eventos
    public function getEnviosEventosReportes()
    {
    
        $reportesEnviosEventos= reporte_envios_evento::select(
            'reporte_envio_evento.id',
            'reporte_envio_evento.nombre_evento',
            'reporte_envio_evento.direccion_entrega',
            'reporte_envio_evento.fecha_envio',
        )
        ->get();


        return view('admin.reportes_envios_eventos.listar', compact('reportesEnviosEventos'));
    }

    //funcion para la información de los materiales gráficos registrados en la base de datos.
    public function create()
    {
         $materiales= materiales_graficos::all();
        
        return view('admin.reportes_envios_eventos.crear', compact('materiales'));
    }

    //funcion store para guardar los reportes de envios de materiales a eventos
    public function store(Request $request)
    {
       
  $validator= $request->validate([
            'nombre_evento' => 'required|string|max:255',
            'direccion_entrega' => 'required|string|max:255',
            'id_destinatario' => 'required|exists:users,id',
            'id_responsable' => 'required|exists:users,id',
            'materiales' => 'required|array|min:1',
            'materiales.*.id' => 'required|exists:materiales_graficos,id',
            'materiales.*.cantidad' => 'required|integer|min:1',
            'fecha_envio' => 'required|date',
            'observaciones' => 'nullable|string|max:255',
        ]);

        reporte_envios_evento::create([
            'nombre_evento' => $request->nombre_evento,
            'direccion_entrega' => $request->direccion_entrega,
            'id_destinatario' => $request->id_destinatario,
            'id_responsable' => $request->id_responsable,
            'fecha_envio' => $request->fecha_envio,
            'observaciones' => $request->observaciones,
        ]);

        $id_reporte_envio_evento = reporte_envios_evento::latest()->first()->id; 

        foreach ($request->materiales as $material) {
            detalle_envio_material::create([
                'id_material_grafico' => $material['id'],
                'id_reporte_envio_evento' => $id_reporte_envio_evento, // Asegúrate de que este ID esté disponible
                'cantidad_enviada' => $material['cantidad'],
            ]);
        }

        

       
    }

    // Funcion encargada de buscar usuarios que coincidan con el término de búsqueda (nombre, apellido o email)
    // y devuelve un JSON con id y texto (nombre completo + email) para la vista

    public function getDestinatarios(Request $request)
    {
        $search = $request->get('search');
        $destinatarios = User::select('id', 'nombre', 'apellido', 'email')
        ->where(function ($query) use ($search) {
        $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', "%{$search}%")
              ->orWhere(DB::raw("CONCAT(apellido, ' ', nombre)"), 'like', "%{$search}%")
              ->orWhere('nombre', 'like', "%{$search}%")
              ->orWhere('apellido', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })
        ->limit(10)
        ->get();


        return response()->json(
            $destinatarios->map(function ($item) {
            return [
            'id' => $item->id,
            'text' => $item->nombre . ' ' . $item->apellido . ' (' . $item->email . ')'
            ];
            })
        );
    }

    //funcion encargada de obtener el detalle del reporte seleccionado por medio del ID enviado como parámetro.
   public function show($id)
{
    $reporte = reporte_envios_evento::select(
            'reporte_envio_evento.id',
            'reporte_envio_evento.nombre_evento',
            'reporte_envio_evento.direccion_entrega',
            'reporte_envio_evento.fecha_envio',
            'reporte_envio_evento.observaciones',
            'u.nombre as destinatario_nombre',
            'u.apellido as destinatario_apellido',
            'r.nombre as responsable_nombre',
            'r.apellido as responsable_apellido'
        )
        ->join('users as u', 'reporte_envio_evento.id_destinatario', '=', 'u.id')
        ->join('users as r', 'reporte_envio_evento.id_responsable', '=', 'r.id')
        ->where('reporte_envio_evento.id', $id)
        ->firstOrFail();

    $materiales = detalle_envio_material::select(
            'm.nombre as material_nombre',
            'm.img as material_img',
            'dem.cantidad_enviada'
        )
        ->from('detalle_envio_material as dem')
        ->join('materiales_graficos as m', 'dem.id_material_grafico', '=', 'm.id')
        ->where('dem.id_reporte_envio_evento', $id)
        ->select('m.nombre as material_nombre', 'dem.cantidad_enviada',
            'm.img as material_img')
        ->get();

    return view('admin.reportes_envios_eventos.ver', compact('reporte', 'materiales'));
}

//funcion la cual obtiene los datos necesarios, desde la base de datos (materiales graficos enviados, destinatario del envio, responsable del envio)
//y los pasa, por medio de la función compact, a la view para poder editar el reporte de envío
public function edit($id)
{
    $reporte = reporte_envios_evento::findOrFail($id);
    $materialesEnviados = detalle_envio_material::where('id_reporte_envio_evento', $id)->get();
    $materiales = materiales_graficos::all();
    $destinatarios = User::all();
    $responsables = User::all();
    return view('admin.reportes_envios_eventos.editar', compact('reporte', 'materiales', 'destinatarios', 'responsables','materialesEnviados'));

}
//funcion la cual se encarga de actualizar los datos del reporte de envío
public function update(Request $request, $id)
{
    
    $validator = $request->validate([
        'nombre_evento' => 'required|string|max:255',
        'direccion_entrega' => 'required|string|max:255',
        'id_destinatario' => 'required|exists:users,id',
        'id_responsable' => 'required|exists:users,id',
        'materiales' => 'required|array|min:1',
        'materiales.*.id' => 'required|exists:materiales_graficos,id',
        'materiales.*.cantidad' => 'required|integer|min:1',
        'fecha_envio' => 'required|date',
        'observaciones' => 'nullable|string|max:255',
    ]);

    $reporte = reporte_envios_evento::findOrFail($id);
    $reporte->update([
        'nombre_evento' => $request->nombre_evento,
        'direccion_entrega' => $request->direccion_entrega,
        'id_destinatario' => $request->id_destinatario,
        'id_responsable' => $request->id_responsable,
        'fecha_envio' => $request->fecha_envio,
        'observaciones' => $request->observaciones,
    ]);


    detalle_envio_material::where('id_reporte_envio_evento', $id)->delete();

    foreach ($request->materiales as $material) {
        detalle_envio_material::create([
            'id_material_grafico' => $material['id'],
            'id_reporte_envio_evento' => $reporte->id,
            'cantidad_enviada' => $material['cantidad'],
        ]);
    }

    return redirect()->route('admin.listar.enviosEventosReportes')->with('success', 'Reporte de envío de evento actualizado exitosamente.');
}

//funcion encargada de obtener los datos del reporte de envío desde la base de datos, generar un PDF con los datos de este reporte y retornar la descarga del PDF.
public function descargarPdf($id)
{
    $reporte = reporte_envios_evento::select(
            'reporte_envio_evento.id',
            'reporte_envio_evento.nombre_evento',
            'reporte_envio_evento.direccion_entrega',
            'reporte_envio_evento.fecha_envio',
            'reporte_envio_evento.observaciones',
            'u.nombre as destinatario_nombre',
            'u.apellido as destinatario_apellido',
            'r.nombre as responsable_nombre',
            'r.apellido as responsable_apellido'
        )
        ->join('users as u', 'reporte_envio_evento.id_destinatario', '=', 'u.id')
        ->join('users as r', 'reporte_envio_evento.id_responsable', '=', 'r.id')
        ->where('reporte_envio_evento.id', $id)
        ->firstOrFail();

    $materiales = detalle_envio_material::select(
            'm.nombre as material_nombre',
            'm.img as material_img',
            'dem.cantidad_enviada'
        )
        ->from('detalle_envio_material as dem')
        ->join('materiales_graficos as m', 'dem.id_material_grafico', '=', 'm.id')
        ->where('dem.id_reporte_envio_evento', $id)
        ->select('m.nombre as material_nombre', 'dem.cantidad_enviada',
            'm.img as material_img')
        ->get();
      PDF::setOptions(['dpi' => 96, 'debugCss' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
    $pdf = PDF::loadView('pdf.reportesEnviosEventos.reporteEnvioEvento', compact('reporte', 'materiales'));
    return $pdf->download('reporte_envio_evento_' . $reporte->id . '.pdf');
}
}