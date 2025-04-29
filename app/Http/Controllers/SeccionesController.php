<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\MetaTag;
use App\Models\Ciudad;
use App\Models\Servicio;
use App\Models\Sector;
use App\Models\Atributo;
use App\Models\Nacionalidad;
use App\Models\SeoTemplate;
use Illuminate\Support\Facades\Storage;


class SeccionesController extends Controller
{
    public function index()
    {
        // Obtén el usuario autenticado
        $usuarioAutenticado = Auth::user();

        // Pasa el usuario a la vista
        return view('seo.index', compact('usuarioAutenticado'));
    }
    public function home()
    {
        $meta = MetaTag::where('page', 'home')->first();
        if (!$meta) {
            $meta = new MetaTag();
            $meta->page = 'home';
        }

        return view('seo.home', compact('meta'));
    }

    public function foroadmin()
    {
        $meta = MetaTag::where('page', 'foro')->first();
        if (!$meta) {
            $meta = new MetaTag();
            $meta->page = 'foro';
        }
        return view('seo.foroadmin'); // Vista para el foro
    }

    public function blogadmin()
    {
        $meta = MetaTag::where('page', 'blog')->first();
        if (!$meta) {
            $meta = new MetaTag();
            $meta->page = 'blogadmin';
        }

        return view('seo.blogadmin', compact('meta'));
    }

    public function publicateForm()
    {
        return view('seo.publicate'); // Vista para publicar
    }
    public function inicio()
    {
        // Obtener las ciudades (ajusta esto según tu modelo de Ciudad)
        $ciudades = Ciudad::all();

        $meta = MetaTag::where('page', 'inicio')->first();
        if (!$meta) {
            $meta = new MetaTag();
            $meta->page = 'inicio-tarjetas';
        }

        // Pasar las ciudades a la vista
        return view('seo.inicio-tarjetas', compact('meta', 'ciudades'));
    }

    public function favoritos()
    {
        $meta = MetaTag::where('page', 'favoritos')->first();
        if (!$meta) {
            $meta = new MetaTag();
            $meta->page = 'favoritos';
        }
        return view('seo.favoritos', compact('meta')); // Pasa $meta a la vista
    }
    public function showRobots()
    {
        $content = Storage::disk('local')->exists('robots.txt')
            ? Storage::disk('local')->get('robots.txt')
            : "User-agent: *\nDisallow:";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    // Mostrar formulario de edición para el robots.txt
    public function editRobots()
    {
        $content = Storage::disk('local')->exists('robots.txt')
            ? Storage::disk('local')->get('robots.txt')
            : "User-agent: *\nDisallow:";

        return view('seo.edit_robots', compact('content'));
    }

    // Guardar cambios en robots.txt
    public function updateRobots(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        Storage::disk('local')->put('robots.txt', $validated['content']);

        return redirect()->route('seo.edit_robots')->with('success', 'El archivo robots.txt se ha actualizado correctamente.');
    }


    public function templatesSecciones()
    {
        $usuarioAutenticado = Auth::user();
        $servicios = Servicio::all();
        $ciudades = Ciudad::all();
        $atributos = Atributo::all();
        $nacionalidades = Nacionalidad::all();
        $sectores = Sector::all(); // Agregar esta línea

        return view('seo.templateunitarios2', compact(
            'usuarioAutenticado',
            'servicios',
            'atributos',
            'ciudades',
            'nacionalidades',
            'sectores' // Agregar esta línea
        ));
    }

    public function getServicioSecciones(Servicio $servicio, Request $request)
    {
        $ciudadId = $request->query('ciudad_id');
        $page = $ciudadId ? "seo/servicios/{$servicio->id}/ciudad/{$ciudadId}" : "seo/servicios/{$servicio->id}";
    
        $seo = SeoTemplate::where('page', $page)
            ->where('tipo', 'servicios')
            ->first();
    
        if (!$seo) {
            return response()->json([
                'meta_title' => '',
                'meta_description' => ''
            ]);
        }
    
        return response()->json($seo);
    }
    
    public function getSectorSecciones(Sector $sector, Request $request)
    {
        $ciudadId = $request->query('ciudad_id');
        $page = $ciudadId ? "seo/sectores/{$sector->id}/ciudad/{$ciudadId}" : "seo/sectores/{$sector->id}";
    
        $seo = SeoTemplate::where('page', $page)
            ->where('tipo', 'sectores')
            ->first();
    
        if (!$seo) {
            return response()->json([
                'meta_title' => '',
                'meta_description' => ''
            ]);
        }
    
        return response()->json($seo);
    }
    
    public function getAtributoSecciones(Atributo $atributo, Request $request)
    {
        $ciudadId = $request->query('ciudad_id');
        $page = $ciudadId ? "seo/atributos/{$atributo->id}/ciudad/{$ciudadId}" : "seo/atributos/{$atributo->id}";
    
        $seo = SeoTemplate::where('page', $page)
            ->where('tipo', 'atributos')
            ->first();
    
        if (!$seo) {
            return response()->json([
                'meta_title' => '',
                'meta_description' => ''
            ]);
        }
    
        return response()->json($seo);
    }
    
    public function getNacionalidadSecciones(Nacionalidad $nacionalidad, Request $request)
    {
        $ciudadId = $request->query('ciudad_id');
        $page = $ciudadId ? "seo/nacionalidades/{$nacionalidad->id}/ciudad/{$ciudadId}" : "seo/nacionalidades/{$nacionalidad->id}";
    
        $seo = MetaTag::where('page', $page)
            ->where('tipo', 'nacionalidades')
            ->first();
    
        if (!$seo) {
            return response()->json([
                'meta_title' => '',
                'meta_description' => ''
            ]);
        }
    
        return response()->json($seo);
    }
    
    public function updateGeneralSecciones(Request $request)
    {   
        
        try {
            Log::info('Iniciando actualización de SEO para general', [
                'ciudad_id' => $request->ciudad_id,
                'ip' => $request->ip()
            ]);
            

            //Log::info('Ciudad encontrada', ['ciudad' => $ciudad]);
    
           /*  $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'titulo' => 'required|max:70',
                'description_template' => 'required|max:10000'
            ]); */

             
            /* $seo = SeoTemplate::updateOrCreate(
                [
                    'tipo' => 'filtro',
                    'filtro' => 'ciudad',
                    'ciudad_id' => $ciudad,
                    
                ],
                $validated
            ); */
            $ciudad = $request->ciudad_id;
            
            $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'meta_title2' => 'required|max:70',
                'meta_description2' => 'required|max:10000'
            ]);
    
           
            $page = "inicio-{$request->ciudad_id}";

            $seo = MetaTag::updateOrCreate(
                [
                    'page' => $page,
                    'tipo' => ''
                ],
                $validated
            );
    
            Log::info('SEO actualizado exitosamente', [
                'seo_id' => $seo->id
            ]);
    
            return response()->json(['success' => true, 'data' => $seo]);
        } catch (\Exception $e) {
            Log::error('Error actualizando SEO', [
                'ciudad_id' => $request->ciudad_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    public function updateServicioSecciones(Request $request)
    {   
        
        try {
            Log::info('Iniciando actualización de SEO para servicio', [
                'servicio_id' => $request->servicio_id,
                'ciudad_id' => $request->ciudad_id,
                'ip' => $request->ip()
            ]);
    
            $servicio = Servicio::findOrFail($request->servicio_id);
            $ciudad = $request->ciudad_id;
            Log::info('Servicio encontrado', ['servicio' => $servicio->nombre]);
    
            /* $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'titulo' => 'required|max:70',
                'description_template' => 'required|max:10000'
            ]); */

            $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'meta_title2' => 'required|max:70',
                'meta_description2' => 'required|max:10000'
            ]);
    
    
           
    
            $page = "seo/servicios/{$servicio->id}/ciudad/{$request->ciudad_id}";
            
    
            // $seo = SeoTemplate::updateOrCreate(
            //     [
            //         'tipo' => 'filtro',
            //         'filtro' => 'servicios',
            //         'ciudad_id' => $ciudad,
                    
            //     ],
            //     $validated
            // );

            $seo = MetaTag::updateOrCreate(
                [
                    'page' => $page,
                    'tipo' => 'servicios'
                ],
                $validated
            );
    
            Log::info('SEO actualizado exitosamente', [
                'seo_id' => $seo->id,
                'page' => $seo->page
            ]);
    
            return response()->json(['success' => true, 'data' => $seo]);
        } catch (\Exception $e) {
            Log::error('Error actualizando SEO', [
                'servicio_id' => $request->servicio_id,
                'ciudad_id' => $request->ciudad_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function updateAtributoSecciones(Request $request)
    {
        try {
            Log::info('Iniciando actualización de SEO para atributo', [
                'atributo_id' => $request->atributo_id,
                'ciudad_id' => $request->ciudad_id,
                'ip' => $request->ip()
            ]);
    
            $atributo = Atributo::findOrFail($request->atributo_id);
            $ciudad = $request->ciudad_id;

            Log::info('Atributo encontrado', ['atributo' => $atributo->nombre]);
    
           /*  $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'titulo' => 'required|max:70',
                'description_template' => 'required|max:10000'
            ]);
            */

            $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'meta_title2' => 'required|max:70',
                'meta_description2' => 'required|max:10000'
            ]);
    
            $page = "seo/atributos/{$atributo->id}/ciudad/{$request->ciudad_id}";
    
           /*  $seo = SeoTemplate::updateOrCreate(
                [
                    'tipo' => 'filtro',
                    'filtro' => 'atributos',
                    'ciudad_id' => $ciudad,
                    
                ],
                $validated
            ); */

            $seo = MetaTag::updateOrCreate(
                [
                    'page' => $page,
                    'tipo' => 'atributos'
                ],
                $validated
            );
    
            Log::info('SEO actualizado exitosamente', [
                'seo_id' => $seo->id,
                'page' => $seo->page
            ]);
    
            return response()->json(['success' => true, 'data' => $seo]);
        } catch (\Exception $e) {
            Log::error('Error actualizando SEO', [
                'atributo_id' => $request->atributo_id,
                'ciudad_id' => $request->ciudad_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function updateNacionalidadSecciones(Request $request)
    {
        try {
            Log::info('Iniciando actualización de SEO para nacionalidad', [
                'nacionalidad_id' => $request->nacionalidad_id,
                'ciudad_id' => $request->ciudad_id,
                'ip' => $request->ip()
            ]);
    
            $nacionalidad = Nacionalidad::findOrFail($request->nacionalidad_id);
            $ciudad = $request->ciudad_id;

            Log::info('Nacionalidad encontrada', ['nacionalidad' => $nacionalidad->nombre]);
    
           /*  $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'titulo' => 'required|max:70',
                'description_template' => 'required|max:10000'
            ]); */
            
            $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'meta_title2' => 'required|max:70',
                'meta_description2' => 'required|max:10000'
            ]);

            $page = "seo/nacionalidades/{$nacionalidad->id}/ciudad/{$request->ciudad_id}";
    
           /*  $seo = SeoTemplate::updateOrCreate(
                [
                    'tipo' => 'filtro',
                    'filtro' => 'nacionalidad',
                    'ciudad_id' => $ciudad,
                    
                ],
                $validated
            ); */

            $seo = MetaTag::updateOrCreate(
                [
                    'page' => $page,
                    'tipo' => 'nacionalidades'
                ],
                $validated
            );

            Log::info('SEO actualizado exitosamente', [
                'seo_id' => $seo->id,
                'page' => $seo->page
            ]);
    
            return response()->json(['success' => true, 'data' => $seo]);
        } catch (\Exception $e) {
            Log::error('Error actualizando SEO', [
                'nacionalidad_id' => $request->nacionalidad_id,
                'ciudad_id' => $request->ciudad_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function updateSectorSecciones(Request $request)
    {
        try {
            Log::info('Iniciando actualización de SEO para sector', [
                'sector_id' => $request->sector_id,
                'ciudad_id' => $request->ciudad_id,
                'ip' => $request->ip()
            ]);
    
            $sector = Sector::findOrFail($request->sector_id);
            $ciudad = $request->ciudad_id;

            Log::info('Sector encontrado', ['sector' => $sector->nombre]);
    
          /*   $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'titulo' => 'required|max:70',
                'description_template' => 'required|max:10000'
            ]); */

            $validated = $request->validate([
                'ciudad_id' => 'required|exists:ciudades,id',
                'meta_title2' => 'required|max:70',
                'meta_description2' => 'required|max:10000'
            ]);

    
            $page = "seo/sectores/{$sector->id}/ciudad/{$request->ciudad_id}";
    
            /* $seo = SeoTemplate::updateOrCreate(
                [
                    'tipo' => 'filtro',
                    'filtro' => 'sectores',
                    'ciudad_id' => $ciudad,
                    
                ],
                $validated
            );
 */
            $seo = MetaTag::updateOrCreate(
                [
                    'page' => $page,
                    'tipo' => 'sectores'
                ],
                $validated
            );
    
            Log::info('SEO actualizado exitosamente', [
                'seo_id' => $seo->id,
                'page' => $seo->page
            ]);
    
            return response()->json(['success' => true, 'data' => $seo]);
        } catch (\Exception $e) {
            Log::error('Error actualizando SEO', [
                'sector_id' => $request->sector_id,
                'ciudad_id' => $request->ciudad_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // Funciones para Disponibilidad
public function getDisponibilidadSecciones(Request $request)
{
    $ciudadId = $request->query('ciudad_id');
    $page = $ciudadId ? "seo/disponibilidad/ciudad/{$ciudadId}" : "seo/disponibilidad";

    $seo = SeoTemplate::where('page', $page)
        ->where('tipo', 'disponibilidad')
        ->first();

    if (!$seo) {
        return response()->json([
            'meta_title' => '',
            'meta_description' => ''
        ]);
    }
    
    return response()->json($seo);
}

public function updateDisponibilidadSecciones(Request $request)
{
    try {
        Log::info('Iniciando actualización de SEO para disponibilidad', [
            'ciudad_id' => $request->ciudad_id,
            'ip' => $request->ip()
        ]);

        $ciudad = $request->ciudad_id;

        /* $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'titulo' => 'required|max:70',
            'description_template' => 'required|max:10000'
        ]); */

        $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'meta_title2' => 'required|max:70',
            'meta_description2' => 'required|max:10000'
        ]);

        $page = "seo/disponibilidad/ciudad/{$request->ciudad_id}";

        /* $seo = SeoTemplate::updateOrCreate(
            [
                'tipo' => 'filtro',
                'filtro' => 'disponibilidad',
                'ciudad_id' => $ciudad,
                
            ],
            $validated
        ); */

        $seo = MetaTag::updateOrCreate(
            [
                'page' => $page,
                'tipo' => 'disponibilidad'
            ],
            $validated
        );
        

        Log::info('SEO de disponibilidad actualizado exitosamente', [
            'seo_id' => $seo->id,
            'ciudad_id' => $request->ciudad_id
        ]);

        return response()->json(['success' => true, 'data' => $seo]);
    } catch (\Exception $e) {
        Log::error('Error actualizando SEO de disponibilidad', [
            'ciudad_id' => $request->ciudad_id,
            'error' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ]);
        return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
    }
}

// Funciones para Reseñas
public function getResenasSecciones(Request $request)
{
    $ciudadId = $request->query('ciudad_id');
    $page = $ciudadId ? "seo/resenas/ciudad/{$ciudadId}" : "seo/resenas";

    $seo = SeoTemplate::where('page', $page)
        ->where('tipo', 'resenas')
        ->first();

    if (!$seo) {
        return response()->json([
            'meta_title' => '',
            'meta_description' => ''
        ]);
    }

    return response()->json($seo);
}

public function updateResenasSecciones(Request $request)
{
    try {
        Log::info('Iniciando actualización de SEO para reseñas', [
            'ciudad_id' => $request->ciudad_id,
            'ip' => $request->ip()
        ]);

        $ciudad = $request->ciudad_id;

        /* $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'titulo' => 'required|max:70',
            'description_template' => 'required|max:10000'
        ]); */
        
        $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'meta_title2' => 'required|max:70',
            'meta_description2' => 'required|max:10000'
        ]);

        $page = "seo/resenas/ciudad/{$request->ciudad_id}";

       /*  $seo = SeoTemplate::updateOrCreate(
            [
                'tipo' => 'filtro',
                'filtro' => 'resenas',
                'ciudad_id' => $ciudad,
                
            ],
            $validated
        ); */

        $seo = MetaTag::updateOrCreate(
            [
                'page' => $page,
                'tipo' => 'resenas'
            ],
            $validated
        );

        Log::info('SEO de reseñas actualizado exitosamente', [
            'seo_id' => $seo->id,
            'ciudad_id' => $request->ciudad_id
        ]);

        return response()->json(['success' => true, 'data' => $seo]);
    } catch (\Exception $e) {
        Log::error('Error actualizando SEO de reseñas', [
            'ciudad_id' => $request->ciudad_id,
            'error' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ]);
        return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
    }
}

// Funciones para Categorías
public function getCategoriaSecciones($categoria, Request $request)
{
    $ciudadId = $request->query('ciudad_id');
    $page = $ciudadId ? "seo/categorias/{$categoria}/ciudad/{$ciudadId}" : "seo/categorias/{$categoria}";

    $seo = SeoTemplate::where('page', $page)
        ->where('tipo', 'categorias')
        ->first();

    if (!$seo) {
        return response()->json([
            'meta_title' => '',
            'meta_description' => ''
        ]);
    }

    return response()->json($seo);
}

public function updateCategoriaSecciones(Request $request)
{
    try {
        Log::info('Iniciando actualización de SEO para categoría', [
            'categoria' => $request->categoria_id,
            'ciudad_id' => $request->ciudad_id,
            'ip' => $request->ip()
        ]);

        $ciudad = $request->ciudad_id;

       /*  $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'categoria_id' => 'required|in:vip,premium,de_lujo,under,masajes',
            'titulo' => 'required|max:70',
            'description_template' => 'required|max:10000'
        ]); */

        $validated = $request->validate([
            'ciudad_id' => 'required|exists:ciudades,id',
            'categoria_id' => 'required|in:vip,premium,de_lujo,under,masajes',
            'meta_title2' => 'required|max:70',
            'meta_description2' => 'required|max:10000'
        ]);

        $page = "seo/categorias/{$request->categoria_id}/ciudad/{$request->ciudad_id}";

        /* $seo = SeoTemplate::updateOrCreate(
            [
                'tipo' => 'filtro',
                'filtro' => 'categorias',
                'ciudad_id' => $ciudad,
                
            ],
            $validated
        ); */

        $seo = MetaTag::updateOrCreate(
            [
                'page' => $page,
                'tipo' => 'categorias'
            ],
            $validated
        );

        Log::info('SEO de categoría actualizado exitosamente', [
            'seo_id' => $seo->id,
            'categoria' => $request->categoria_id,
            'ciudad_id' => $request->ciudad_id
        ]);

        return response()->json(['success' => true, 'data' => $seo]);
    } catch (\Exception $e) {
        Log::error('Error actualizando SEO de categoría', [
            'categoria' => $request->categoria_id,
            'ciudad_id' => $request->ciudad_id,
            'error' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ]);
        return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
    }
}

}
