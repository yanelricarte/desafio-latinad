<?php

namespace App\Http\Controllers;

use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Annotations as OA;

class DisplayController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/displays",
     *     summary="Listar pantallas del usuario autenticado",
     *     tags={"Displays"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="name", in="query", description="Filtrar por nombre", @OA\Schema(type="string")),
     *     @OA\Parameter(name="type", in="query", description="Filtrar por tipo", @OA\Schema(type="string", enum={"indoor", "outdoor"})),
     *     @OA\Parameter(name="perPage", in="query", description="Cantidad de resultados por página", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Listado paginado de pantallas"),
     *     @OA\Response(response=401, description="No autorizado")
     * )
     */
    public function index(Request $request)
    {
        $query = Display::where('user_id', auth('api')->id());

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->paginate($request->perPage ?? 10));
    }

    /**
     * @OA\Get(
     *     path="/api/displays/{id}",
     *     summary="Ver una pantalla por ID",
     *     tags={"Displays"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Pantalla encontrada"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Display $display)
    {
        if ($display->user_id !== auth('api')->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return response()->json($display);
    }

    /**
     * @OA\Post(
     *     path="/api/displays",
     *     summary="Crear nueva pantalla",
     *     tags={"Displays"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "price_per_day", "resolution_height", "resolution_width", "type"},
     *             @OA\Property(property="name", type="string", example="Pantalla LED"),
     *             @OA\Property(property="description", type="string", example="Pantalla ubicada en esquina comercial"),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=1000),
     *             @OA\Property(property="resolution_height", type="integer", example=1080),
     *             @OA\Property(property="resolution_width", type="integer", example=1920),
     *             @OA\Property(property="type", type="string", enum={"indoor", "outdoor"}, example="indoor")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pantalla creada"),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric',
            'resolution_height' => 'required|integer',
            'resolution_width' => 'required|integer',
            'type' => 'required|in:indoor,outdoor',
        ]);

        $validated['user_id'] = auth('api')->id();
        $display = Display::create($validated);

        return response()->json($display, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/displays/{id}",
     *     summary="Actualizar pantalla existente",
     *     tags={"Displays"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "price_per_day", "resolution_height", "resolution_width", "type"},
     *             @OA\Property(property="name", type="string", example="Pantalla LED"),
     *             @OA\Property(property="description", type="string", example="Actualizada con nueva ubicación"),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=950),
     *             @OA\Property(property="resolution_height", type="integer", example=720),
     *             @OA\Property(property="resolution_width", type="integer", example=1280),
     *             @OA\Property(property="type", type="string", enum={"indoor", "outdoor"}, example="outdoor")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pantalla actualizada"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function update(Request $request, Display $display)
    {
        if ($display->user_id !== auth('api')->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric',
            'resolution_height' => 'required|integer',
            'resolution_width' => 'required|integer',
            'type' => 'required|in:indoor,outdoor',
        ]);

        $display->update($validated);

        return response()->json($display);
    }

    /**
     * @OA\Delete(
     *     path="/api/displays/{id}",
     *     summary="Eliminar una pantalla",
     *     tags={"Displays"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Pantalla eliminada"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function destroy($id)
    {
        $display = Display::find($id);

        if (!$display) {
            return response()->json([
                'error' => 'La pantalla no existe o ya fue eliminada.'
            ], 404);
        }

        $this->authorize('delete', $display);
        $display->delete();

        return response()->json([
            'message' => 'Pantalla eliminada correctamente.'
        ]);
    }
}
