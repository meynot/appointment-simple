<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->string('search'));
        $appointmentFilter = $request->string('appointments')->toString();

        $clients = Client::query()
            ->withCount('appointments')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($appointmentFilter === 'with', fn ($query) => $query->has('appointments'))
            ->when($appointmentFilter === 'without', fn ($query) => $query->doesntHave('appointments'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $filters = [
            'search' => $search,
            'appointments' => $appointmentFilter,
        ];

        $stats = [
            'total' => Client::query()->count(),
            'withAppointments' => Client::query()->has('appointments')->count(),
            'withoutAppointments' => Client::query()->doesntHave('appointments')->count(),
        ];

        return view('clients.index', compact('clients', 'filters', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', __('Client created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load([
            'appointments' => fn ($query) => $query
                ->with('creator')
                ->orderByDesc('appointment_date'),
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', __('Client updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', __('Client deleted successfully.'));
    }
}
