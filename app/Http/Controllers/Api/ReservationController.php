<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

        if (!$request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $reservations = $query
            ->orderBy('start_date')
            ->get();

        return response()->json([
            'data' => $reservations,
        ], 200);
    }

    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

        $vehicle = Vehicle::where('id', $data['vehicle_id'])
            ->where('is_active', true)
            ->first();

        if (!$vehicle) {
            return response()->json([
                'message' => 'El vehículo no existe o no está disponible.',
            ], 404);
        }

        $overlappingReservation = Reservation::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_date', '<=', $data['end_date'])
            ->where('end_date', '>=', $data['start_date'])
            ->exists();

        if ($overlappingReservation) {
            return response()->json([
                'message' => 'El vehículo ya está reservado en ese rango de fechas.',
            ], 409);
        }

        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $days = $startDate->diffInDays($endDate) + 1;

        $reservation = Reservation::create([
            'user_id' => $request->user()->id,
            'vehicle_id' => $vehicle->id,
            'vehicle_name' => $vehicle->name,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days' => $days,
            'total_price' => $days * (float) $vehicle->price_per_day,
            'status' => 'pending',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Reserva creada correctamente.',
            'data' => $reservation,
        ], 201);
    }

    public function show(Request $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Reserva no encontrada.',
            ], 404);
        }

        if (!$request->user()->isAdmin() && $reservation->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No puedes ver esta reserva.',
            ], 403);
        }

        return response()->json([
            'data' => $reservation,
        ], 200);
    }

    public function update(UpdateReservationRequest $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Reserva no encontrada.',
            ], 404);
        }

        if (!$request->user()->isAdmin() && $reservation->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No puedes modificar esta reserva.',
            ], 403);
        }

        $data = $request->validated();

        if (!$request->user()->isAdmin()) {
            unset($data['status']);
        }

        $startDate = $data['start_date'] ?? $reservation->start_date;
        $endDate = $data['end_date'] ?? $reservation->end_date;

        $overlap = Reservation::where('vehicle_id', $reservation->vehicle_id)
            ->where('_id', '!=', $reservation->_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate)
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'El vehículo ya está reservado en ese rango de fechas.',
            ], 409);
        }

        $vehicle = Vehicle::find($reservation->vehicle_id);

        if (!$vehicle) {
            return response()->json([
                'message' => 'El vehículo asociado ya no existe.',
            ], 404);
        }

        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;

        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['days'] = $days;
        $data['total_price'] = $days * (float) $vehicle->price_per_day;

        $reservation->update($data);

        return response()->json([
            'message' => 'Reserva actualizada correctamente.',
            'data' => $reservation->fresh(),
        ], 200);
    }

    public function destroy(Request $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Reserva no encontrada.',
            ], 404);
        }

        if (!$request->user()->isAdmin() && $reservation->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No puedes eliminar esta reserva.',
            ], 403);
        }

        $reservation->delete();

        return response()->json(null, 204);
    }
}