<?php

namespace App\Http\Controllers;

use App\Models\HistorialDeModificacionesPorSolicitude;
use Illuminate\Http\Request;
use App\Models\Solicitude;
use App\Models\Nodo;
use App\Models\User;
use App\Models\HistorialDeUsuariosPorSolicitude;
use DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    

        return view('home');
    }

    public function datosGraficas()
    {
        $usuarioAutenticado = Auth::user();
        $rolesPermitidos = ['Super Admin', 'Admin', 'Activador Nacional'];
        $rolesDesigner = ['Designer'];
        $rolSuperAdmin = $usuarioAutenticado->hasAnyRole($rolesPermitidos);
        $esDesigner = $usuarioAutenticado->hasAnyRole($rolesDesigner); 
        $nodoUsuario = $usuarioAutenticado->id_nodo;
        $tiposDeSolicitudes = [];
        
        if ($rolSuperAdmin) {
            $propias = Solicitude::count();
            $totalModificacionesGeneral = HistorialDeModificacionesPorSolicitude::count();
            $total = $propias + $totalModificacionesGeneral;

            $tiposDeSolicitudes = Solicitude::join('tipos_de_solicitudes', 'solicitudes.id_tipos_de_solicitudes', '=', 'tipos_de_solicitudes.id')
            ->select('tipos_de_solicitudes.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('tipos_de_solicitudes.nombre')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

            // Obtener datos de solicitudes por mes
            $solicitudes = Solicitude::select(DB::raw('COUNT(*) as total_solicitudes, YEAR(created_at) as anio, MONTH(created_at) as mes'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

            // Obtener datos de modificaciones por mes
            $modificaciones = HistorialDeModificacionesPorSolicitude::select(DB::raw('COUNT(*) as total_modificaciones, YEAR(created_at) as anio, MONTH(created_at) as mes'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

            foreach ($solicitudes as $solicitud) {
                $mes = $solicitud->mes;
                $anio = $solicitud->anio;
                $totalSolicitudes = $solicitud->total_solicitudes;
            
                // Buscar las modificaciones correspondientes a este mes y año
                $modificacion = $modificaciones->where('mes', $mes)->where('anio', $anio)->first();
                $totalModificaciones = $modificacion ? $modificacion->total_modificaciones : 0;
            
                // Agregar los datos al array
                $datosMesAMes[] = [
                    'mes' => $mes,
                    'anio' => $anio,
                    'total_solicitudes' => $totalSolicitudes,
                    'total_modificaciones' => $totalModificaciones
                ];
            }

            $data = DB::table('solicitudes')
            ->join('users', 'solicitudes.id_usuario_que_realiza_la_solicitud', '=', 'users.id')
            ->join('nodos', 'users.id_nodo', '=', 'nodos.id')
            ->select('nodos.nombre', DB::raw('COUNT(*) as total_solicitudes'))
            ->groupBy('nodos.nombre')
            ->orderBy('nodos.nombre')
            ->get();

            // Obtener los datos de modificaciones por nodo
            $modificacionesNodo = DB::table('historial_de_modificaciones_por_solicitudes')
            ->join('solicitudes', 'historial_de_modificaciones_por_solicitudes.id_soli', '=', 'solicitudes.id')
            ->join('users', 'solicitudes.id_usuario_que_realiza_la_solicitud', '=', 'users.id')
            ->join('nodos', 'users.id_nodo', '=', 'nodos.id')
            ->select('nodos.nombre', DB::raw('COUNT(*) as total_modificaciones'))
            ->groupBy('nodos.nombre')
            ->orderBy('nodos.nombre')
            ->get();

            // Combinar los datos de solicitudes y modificaciones por nodo
            // Combinar los datos de solicitudes y modificaciones por nodo
            $datosPorNodo = [];
            foreach ($data as $solicitud) {
                $nombreNodo = $solicitud->nombre;
                $totalSolicitudes = $solicitud->total_solicitudes;

                // Buscar las modificaciones correspondientes a este nodo
                $modificacion = $modificacionesNodo->firstWhere('nombre', $nombreNodo);
                $totalModificaciones = $modificacion ? $modificacion->total_modificaciones : 0;

                // Agregar los datos al array
                $datosPorNodo[] = [
                    'nombre' => $nombreNodo,
                    'total_solicitudes' => $totalSolicitudes,
                    'total_modificaciones' => $totalModificaciones
                ];
            }


            //Consultas para asignadas

            // Obtener todos los usuarios con rol DESIGNER
            $usuariosDesigners = User::role('DESIGNER')->pluck('id');

            // Consultar el número de historiales con id_estados = 1 para cada usuario
            $historiales = DB::table('historial_de_usuarios_por_solicitudes')
                ->whereIn('id_users', $usuariosDesigners)
                ->where('id_estados', 1)
                ->select('id_users', DB::raw('COUNT(*) as cantidad'))
                ->groupBy('id_users')
                ->get();

            // Construir un array asociativo con la cantidad de historiales para cada usuario
            $datosGraficaAsignadas = [];
            foreach ($usuariosDesigners as $usuarioId) {
                $cantidadHistoriales = $historiales->where('id_users', $usuarioId)->first();
                if ($cantidadHistoriales) {
                    $datosGraficaAsignadas[] = ['usuario' => $usuarioId, 'cantidad' => $cantidadHistoriales->cantidad];
                } else {
                    $datosGraficaAsignadas[] = ['usuario' => $usuarioId, 'cantidad' => 0];
                }
            }

            // Obtener los nombres de los usuarios
            $nombresUsuarios = User::whereIn('id', $usuariosDesigners)->pluck('name', 'id');

            // Combinar los datos de la gráfica con los nombres de los usuarios
            foreach ($datosGraficaAsignadas as &$dato) {
                $dato['nombre'] = $nombresUsuarios[$dato['usuario']];
            }

            // Ordenar los datos por nombre de usuario
            usort($datosGraficaAsignadas, function ($a, $b) {
                return strcmp($a['nombre'], $b['nombre']);
            });

            // Obtener los nombres de los usuarios para etiquetas de la gráfica
            $etiquetas = array_column($datosGraficaAsignadas, 'nombre');

            // Obtener las cantidades de historiales para los datos de la gráfica
            $cantidades_asignadas = array_column($datosGraficaAsignadas, 'cantidad');
            


            return response()->json(['solicitudes' => $propias, 'modificaciones'=> $totalModificacionesGeneral, 'total'=>$total, 'tiposDeSolicitudes'=>$tiposDeSolicitudes, 'datos_mes_a_mes' => $datosMesAMes, 'datosPorNodo' => $datosPorNodo,'etiquetas' => $etiquetas ,'cantidades_asignadas' => $cantidades_asignadas]);

            }
        elseif ($esDesigner) {

            $idsSolicitudes = HistorialDeUsuariosPorSolicitude::where('id_users', $usuarioAutenticado->id)
            ->pluck('id_solicitudes');
            
            $propias = $idsSolicitudes->count();

            // Realizar una unión para incluir tanto las solicitudes como las modificaciones
            $historiales1 = DB::table('solicitudes')
            ->select('solicitudes.id')
            ->whereIn('solicitudes.id', $idsSolicitudes)
            ->unionAll(
                HistorialDeModificacionesPorSolicitude::whereIn('id_soli', $idsSolicitudes)
                    ->select('id_soli as id')
            );

            $totalModificaciones = HistorialDeModificacionesPorSolicitude::whereIn('id_soli', $idsSolicitudes)->count();

            $total = $propias + $totalModificaciones;

            $tiposDeSolicitudes = DB::table('solicitudes')
            ->join('tipos_de_solicitudes', 'solicitudes.id_tipos_de_solicitudes', '=', 'tipos_de_solicitudes.id')
            ->whereIn('solicitudes.id', $idsSolicitudes)
            ->select('tipos_de_solicitudes.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('tipos_de_solicitudes.nombre')
            ->orderByDesc('total')
            ->get();
            


            // Obtener todos los IDs únicos de solicitudes e historial de modificaciones
            $historiales = DB::table('solicitudes')
            ->select('solicitudes.id')
            ->whereIn('solicitudes.id', $idsSolicitudes)
            ->unionAll(
                HistorialDeModificacionesPorSolicitude::whereIn('id_soli', $idsSolicitudes)
                    ->select('id_soli as id')
            )->distinct()->get()->pluck('id')->toArray();

            // Recorrer cada ID y contar las solicitudes
            foreach ($historiales as $id) {
                // Contar las solicitudes para el ID actual
                $totalSolicitudes = Solicitude::where('id', $id)
                    ->count();

                // Obtener el mes y año de la solicitud
                $solicitud = Solicitude::where('id', $id)->first();
                $mes = $solicitud->created_at->month;
                $anio = $solicitud->created_at->year;

                // Agregar los datos al array asociativo usando mes y año como clave
                $clave = $anio . '-' . $mes;
                if (!isset($datosMesAMes[$clave])) {
                    $datosMesAMes[$clave] = [
                        'mes' => $mes,
                        'anio' => $anio,
                        'total_solicitudes' => 0, // Inicializar en 0 para sumar luego
                    ];
                }

                // Incrementar el total de solicitudes para el mes y año actual
                $datosMesAMes[$clave]['total_solicitudes'] += $totalSolicitudes;
            }

            // Convertir el array asociativo a un array indexado
            $datosMesAMes = array_values($datosMesAMes);

            return response()->json(['solicitudes' => $propias, 'modificaciones'=> $totalModificaciones, 'total'=>$total, 'tiposDeSolicitudes'=>$tiposDeSolicitudes, 'datos_mes_a_mes' => $datosMesAMes]);
            } else {
            $propias = Solicitude::where('id_usuario_que_realiza_la_solicitud', $usuarioAutenticado->id)->count();
            
            $totalModificaciones = HistorialDeModificacionesPorSolicitude::whereIn('id_soli', function ($query) use ($usuarioAutenticado) {
                $query->select('id')
                    ->from('solicitudes')
                    ->where('id_usuario_que_realiza_la_solicitud', $usuarioAutenticado->id);
            })->count();
            $total = $propias + $totalModificaciones;

            $tiposDeSolicitudes = Solicitude::where('id_usuario_que_realiza_la_solicitud', $usuarioAutenticado->id)
            ->join('tipos_de_solicitudes', 'solicitudes.id_tipos_de_solicitudes', '=', 'tipos_de_solicitudes.id')
            ->select('tipos_de_solicitudes.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('tipos_de_solicitudes.nombre')
            ->orderBy('total', 'desc')
            ->get();

            $solicitudes = Solicitude::where('id_usuario_que_realiza_la_solicitud', $usuarioAutenticado->id)
            ->select(DB::raw('COUNT(*) as total_solicitudes, YEAR(created_at) as anio, MONTH(created_at) as mes'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

            foreach ($solicitudes as $solicitud) {
                $mes = $solicitud->mes;
                $anio = $solicitud->anio;
                $totalSolicitudes = $solicitud->total_solicitudes;
        
                // Agregar los datos al array
                $datosMesAMes[] = [
                    'mes' => $mes,
                    'anio' => $anio,
                    'total_solicitudes' => $totalSolicitudes
                ];
            }

            return response()->json(['solicitudes' => $propias, 'modificaciones'=> $totalModificaciones, 'total'=>$total, 'tiposDeSolicitudes'=>$tiposDeSolicitudes, 'datos_mes_a_mes' => $datosMesAMes]);

        }

    }

}
