<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applications = Application::where('status', 1)->get();
        $type = [
            ['value' => 'bug', 'name' => 'Bug'],
            ['value' => 'feature', 'name' => 'New Feature'],
            ['value' => 'improvement', 'name' => 'Improvement'],
        ];
        $status = [
            ['value' => 'pending', 'name' => 'Pending'],
            ['value' => 'in_progress', 'name' => 'In Progress'],
            ['value' => 'completed', 'name' => 'Completed'],
            ['value' => 'rejected', 'name' => 'Rejected'],
            ['value' => 'testing', 'name' => 'Testing'],
            ['value' => 'approved', 'name' => 'Approved'],
        ];

        return Inertia::render('Request', [
            'applications' => $applications,
            'type_request' => $type,
            'status_request' => $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('xxxxx');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
