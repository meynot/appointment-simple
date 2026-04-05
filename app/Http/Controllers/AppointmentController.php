<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = $request->string('status')->toString();
        $clientId = $request->integer('client_id');

        $appointments = Appointment::query()
            ->with(['client', 'creator'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('sequence_number', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")
                        ->orWhereHas('client', fn ($clientQuery) => $clientQuery->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('creator', fn ($userQuery) => $userQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when(in_array($status, ['pending', 'completed'], true), fn ($query) => $query->where('status', $status))
            ->when($clientId > 0, fn ($query) => $query->where('client_id', $clientId))
            ->orderByDesc('appointment_date')
            ->paginate(10)
            ->withQueryString();

        $clients = Client::query()->orderBy('name')->get(['id', 'name']);

        $filters = [
            'search' => $search,
            'status' => $status,
            'client_id' => $clientId > 0 ? $clientId : null,
        ];

        $stats = [
            'total' => Appointment::query()->count(),
            'pending' => Appointment::query()->where('status', 'pending')->count(),
            'completed' => Appointment::query()->where('status', 'completed')->count(),
        ];

        return view('appointments.index', compact('appointments', 'clients', 'filters', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::query()->orderBy('name')->get();
        $selectedClientId = request()->integer('client_id') ?: null;

        return view('appointments.create', compact('clients', 'selectedClientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        Appointment::create([
            ...$request->validated(),
            'created_by' => Auth::id(),
            'sequence_number' => $this->nextSequenceNumber(),
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', __('Appointment created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load(['client', 'creator']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): View
    {
        $clients = Client::query()->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        return redirect()
            ->route('appointments.index')
            ->with('success', __('Appointment updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', __('Appointment deleted successfully.'));
    }

    private function nextSequenceNumber(): int
    {
        return (int) Appointment::query()->max('sequence_number') + 1;
    }
}
