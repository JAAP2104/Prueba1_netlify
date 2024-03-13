<?php

namespace App\Http\Controllers;

use App\Models\DatosUnicosPorSolicitude;
use App\Models\Estado;
use App\Models\EstadosDeLasSolictude;
use App\Models\EventosEspecialesPorCategoria;
use App\Models\Solicitude;
use App\Models\TiposDeDato;
use App\Models\TiposDeSolicitude;
use App\Models\ServiciosPorTiposDeSolicitude; // Añade la importación de la clase ServiciosPorTiposDeSolicitudes
use Illuminate\Http\Request;
use App\Models\Politica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


/**
 * Class SolicitudeController
 * @package App\Http\Controllers
 */
class SolicitudeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = Solicitude::paginate();
        $currentTime = $this->getCurrentTimeInBogota();
        return view('solicitude.index', compact('solicitudes','currentTime'))
             ->with('i', (request()->input('page', 1) - 1) * $solicitudes->perPage());
     }
   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitude = new Solicitude();
        $estados = EstadosDeLasSolictude::all();
        $solicitudes = TiposDeSolicitude::all();
        $especiales = EventosEspecialesPorCategoria::all();

         // Recuperar el registro de la Politica con id_estado = 1
         $politicas = Politica::where('id_estado', 1)->first();

    
        return view('solicitude.create', compact('solicitude','estados' , 'solicitudes' , 'especiales', 'politicas'));
    }

    /**
     * Process the selected ID from the dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processSelectedId(Request $request)
    {
        $selectedTypeId = $request->input('tipo_solicitud_id');

        // Obtener los datos únicos por solicitud asociados al tipo de solicitud seleccionado
        $datosUnicos = DatosUnicosPorSolicitude::where('id_tipos_de_solicitudes', $selectedTypeId)->get();
    
        // Obtener los servicios por solicitud asociados al tipo de solicitud seleccionado
        $servicios = ServiciosPorTiposDeSolicitude::where('id_tipo_de_solicitud', $selectedTypeId)->get();
        $tiposDeDatos = TiposDeDato::all();
        // Devolver los datos en formato JSON
        return response()->json([
            'datos_unicos' => $datosUnicos,
            'servicios' => $servicios,
            'tipos_de_datos' => $tiposDeDatos
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Solicitude::$rules);

        $solicitude = Solicitude::create($request->all());

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitude created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solicitude = Solicitude::find($id);

        // Realiza una consulta para obtener los elementos por solicitud
        $elementos = DB::table('elementos_por_solicitudes')
                        ->join('servicios_por_tipos_de_solicitudes', 'elementos_por_solicitudes.id_subservicios', '=', 'servicios_por_tipos_de_solicitudes.id')
                        ->select('servicios_por_tipos_de_solicitudes.nombre')
                        ->where('elementos_por_solicitudes.id_solicitudes', $id)
                        ->get();

        $datosPorSolicitud =  DB::table('datos_por_solicitud')
                                ->join('datos_unicos_por_solicitudes', 'datos_por_solicitud.id_datos_unicos_por_solicitudes', '=', 'datos_unicos_por_solicitudes.id')
                                ->select('datos_unicos_por_solicitudes.nombre as titulo', 'datos_por_solicitud.dato')
                                ->where('datos_por_solicitud.id_solicitudes', $id)
                                ->get();

        // Retorna la vista con los datos necesarios
        return view('solicitude.show', compact('solicitude', 'elementos', 'datosPorSolicitud'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitude = Solicitude::find($id);

        return view('solicitude.edit', compact('solicitude'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Solicitude $solicitude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitude $solicitude)
    {
        request()->validate(Solicitude::$rules);

        $solicitude->update($request->all());

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitude updated successfully');
    }

    // /**
    //  * Obtiene la hora actual en la zona horaria de Bogotá.
    //  *
    //  * @return string|null
    //  */
    // public function getCurrentTimeInBogota()
    // {
    //     $response = Http::get('https://timeapi.io/api/Time/current/zone?timeZone=America/Bogota');

    //     if ($response->successful()) {
    //         return $response['dateTime'];
    //     } else {
    //         return null;
    //     }
    // }

    /**
 * Obtiene la hora actual en la zona horaria de Bogotá.
 *
 * @return array|null
 */
public function getCurrentTimeInBogota()
{
    $response = Http::get('https://timeapi.io/api/Time/current/zone?timeZone=America/Bogota', [
        'timeZone' => 'America/Bogota',
    ]);

    if ($response->successful()) {
        $dateTime = $response['dateTime'];
        $dateTimeParts = explode('T', $dateTime); // Separar la fecha y la hora

        return [
            'date' => $dateTimeParts[0], // Obtener la fecha
            'time' => substr($dateTimeParts[1], 0, 8), // Obtener la hora
        ];
    } else {
        return null;

        
    }
}

   

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    // public function destroy($id)
    // {
    //     $solicitude = Solicitude::find($id)->delete();

    //     return redirect()->route('solicitudes.index')
    //         ->with('success', 'Solicitude deleted successfully');
    // }
}
