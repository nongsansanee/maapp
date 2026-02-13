<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Request as ModelsRequest;
use App\Models\RequestTimeline as ModelsRequest_Timeline;

use function PHPSTORM_META\map;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = ModelsRequest::query()
            ->get()
            ->map(function ($request) {
            return [
                'id' => $request->id,
                'user_id' => $request->user_id,
                'user_name' => $request->user->name,
                'requester' => $request->requester,
                'date_request' => $request->date_request,
                'application_id' => $request->application->id,
                'application_name_th' => $request->application->name_th,
                'application_name_en' => $request->application->name_en,
                'application_admin' => $request->application->application_admin,
                'type_request' => $request->type_request,
                'description' => $request->description,
                'actor' => $request->RequestTimeline[0]->name,
                'status_request' => $request->RequestTimeline[0]->status_request
            ];
        });

        // foreach ($requests as &$request) {
        //     $request['date_request'] = date('d-m-Y', strtotime($request['date_request']));
        //     $request['type_request'] = match ($request['type_request']) {
        //         'bug' => 'Bug',
        //         'new_feature' => 'New Feature',
        //         'improvement' => 'Improvement',
        //     };
        // };
        return Inertia::render('RequestIndex', [
            'requests' => $requests
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applications = Application::where('status', 1)->get();
        $type = [
            ['value' => 'bug', 'name' => 'Bug'],
            ['value' => 'new_feature', 'name' => 'New Feature'],
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

        return Inertia::render('RequestCreate', [
            'applications' => $applications,
            'type_request' => $type,
            'status_request' => $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request)
    {
        // dd($request->all());

        $Modelrequest = ModelsRequest::create([
            'user_id' => $request->user_id,
            'requester' => $request->requester,
            'date_request' => $request->date_request,
            'application_id' => $request->application,
            'type_request' => $request->type_request,
            'description' => $request->description,
            'name' => $request->actor,
            'status_request' => $request->status_request,
        ]);

        ModelsRequest_Timeline::create([
            'request_id' => $Modelrequest->id,
            'name' => $request->actor,
            'status_request' => $request->status_request,
        ]);

        // return back()->with([
        //     "intent" => "success",
        //     'msg' => 'Request submitted successfully!',
        // ]);
        return redirect()->route('request.index')->with([
            "intent" => "success",
            'msg' => 'Request submitted successfully!',
        ]);
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
    public function edit(ModelsRequest $request)
    {
        // dd('Edit request with ID:', $id);
        // $request = ModelsRequest::query()
        //     ->where('id', $id)
        //     ->get()
        //     ->map(function ($request) {
        //         return [
        //             'id' => $request->id,
        //             'user_id' => $request->user_id,
        //             'user_name' => $request->user->name,
        //             'requester' => $request->requester,
        //             'date_request' => $request->date_request,
        //             'application_id' => $request->application->id,
        //             'application_name_th' => $request->application->name_th,
        //             'application_name_en' => $request->application->name_en,
        //             'application_admin' => $request->application->application_admin,
        //             'type_request' => $request->type_request,
        //             'description' => $request->description,
        //             'actor' => $request->RequestTimeline[0]->name,
        //             'status_request' => $request->RequestTimeline[0]->status_request
        //         ];
        //     })->first();

    
        $request = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'user_name' => $request->user->name,
            'requester' => $request->requester,
            'date_request' => $request->date_request,
            'application_id' => $request->application->id,
            'application_name_th' => $request->application->name_th,
            'application_name_en' => $request->application->name_en,
            'application_admin' => $request->application->application_admin,
            'type_request' => $request->type_request,
            'description' => $request->description,
            'actor' => $request->RequestTimeline[0]->name,
            'status_request' => $request->RequestTimeline[0]->status_request
        ];

        $type = [
            ['value' => 'bug', 'name' => 'Bug'],
            ['value' => 'new_feature', 'name' => 'New Feature'],
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
        $applications = Application::where('status', 1)->get();

        return Inertia::render('RequestEdit', [
            'request' => $request,
            'type_request' => $type,
            'status_request' => $status,
            'applications' => $applications,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequestRequest $request, string $id)
    {
        // dd($request->all(), $id);

        $request_timeline = ModelsRequest_Timeline::where('request_id', $id)->first();
        $request_timeline->update([
            'name' => $request->actor,
            'status_request' => $request->status_request,
            'request_id' => $id,
        ]);

        $request_data = ModelsRequest::where('id', $id)->first();
        $request_data->update([
            'user_id' => $request->user_id,
            'requester' => $request->requester,
            'date_request' => $request->date_request,
            'application_id' => $request->application,
            'type_request' => $request->type_request,
            'description' => $request->description,
        ]);

        return redirect()->route('request.index')->with([
            "intent" => "success",
            'msg' => 'Request updated successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
