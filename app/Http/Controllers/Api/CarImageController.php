<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Models\CarImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CarImageResource;

class CarImageController
{
    /**
     * CRUD 2: Display all images for authenticated user's cars
     * GET /api/car-images
     */
    public function index(Request $request)
    {
        $images = CarImages::whereHas('car', function ($query) {
            return $query->where('user_id', Auth::id());
        })
            ->with(['car' => function ($query) {
                $query->select('id', 'maker_id', 'model_id');
            }])
            ->orderBy('car_id')
            ->orderBy('position')
            ->paginate($request->input('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Images retrieved successfully',
            'data' => CarImageResource::collection($images),
            'pagination' => [
                'total' => $images->total(),
                'per_page' => $images->perPage(),
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
            ]
        ], 200);
    }

    /**
     * Get images for a specific car
     * GET /api/cars/{car}/images
     */
    public function carImages(Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $images = $car->images()->orderBy('position')->get();

        return response()->json([
            'success' => true,
            'message' => 'Car images retrieved successfully',
            'data' => CarImageResource::collection($images)
        ], 200);
    }

    /**
     * Store a new image for authenticated user's car
     * POST /api/car-images
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => ['required', 'exists:cars,id'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'position' => ['nullable', 'integer', 'min:1'],
        ]);

        // Verify ownership
        $car = Car::findOrFail($validated['car_id']);
        if ($car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Store the image
        $path = $request->file('image')->store('cars', 'public');
        
        $position = $validated['position'] ?? ($car->images()->max('position') + 1) ?? 1;

        $image = $car->images()->create([
            'image_path' => $path,
            'position' => $position,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'data' => new CarImageResource($image)
        ], 201);
    }

    /**
     * Store image for car (via route parameter)
     * POST /api/cars/{car}/images
     */
    public function storeForCar(Request $request, Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->merge(['car_id' => $car->id]);
        return $this->store($request);
    }

    /**
     * Display a specific image
     * GET /api/car-images/{id}
     */
    public function show(CarImages $carImage)
    {
        // Verify ownership
        if ($carImage->car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image retrieved successfully',
            'data' => new CarImageResource($carImage)
        ], 200);
    }

    /**
     * Update image position
     * PUT /api/car-images/{id}
     */
    public function update(Request $request, CarImages $carImage)
    {
        // Verify ownership
        if ($carImage->car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'position' => ['required', 'integer', 'min:1'],
        ]);

        $carImage->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully',
            'data' => new CarImageResource($carImage)
        ], 200);
    }

    /**
     * Delete an image
     * DELETE /api/car-images/{id} or DELETE /api/images/{id}
     */
    public function destroy($id)
    {
        $image = CarImages::findOrFail($id);

        // Verify ownership
        if ($image->car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete file from storage if it wasn't a remote URL
        if (strpos($image->image_path, 'http') !== 0) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ], 200);
    }
}
