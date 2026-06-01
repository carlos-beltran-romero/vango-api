<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Reservation;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if (!$request->user()?->isAdmin()) {
            $query->where('is_active', true);
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', (int) $request->capacity);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', (float) $request->max_price);
        }

        $vehicles = $query
            ->orderBy('price_per_day')
            ->get();

        return response()->json([
            'data' => $vehicles,
        ], 200);
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return response()->json([
            'message' => 'Vehículo creado correctamente.',
            'data' => $vehicle,
        ], 201);
    }

    public function show(Vehicle $vehicle)
    {
        if (!$vehicle->is_active && !request()->user()?->isAdmin()) {
            return response()->json([
                'message' => 'Vehículo no disponible.',
            ], 404);
        }

        return response()->json([
            'data' => $vehicle,
        ], 200);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json([
            'message' => 'Vehículo actualizado correctamente.',
            'data' => $vehicle,
        ], 200);
    }

    public function destroy(Vehicle $vehicle)
    {
        $hasActiveReservations = Reservation::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveReservations) {
            return response()->json([
                'message' => 'No se puede eliminar un vehículo con reservas activas.',
            ], 409);
        }

        $vehicle->delete();

        return response()->json(null, 204);
    }

    public function availability(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $isAvailable = !Reservation::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->exists();

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1;

        return response()->json([
            'vehicle_id' => $vehicle->id,
            'available' => $isAvailable,
            'days' => $days,
            'estimated_price' => $days * (float) $vehicle->price_per_day,
        ], 200);
    }
}