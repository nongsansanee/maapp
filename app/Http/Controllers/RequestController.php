<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Request as ModelsRequest;
use App\Models\RequestTimeline as ModelsRequest_Timeline;
use PhpParser\Node\Expr\AssignOp\Mod;

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
                    'date_request' => date('d-m-Y', strtotime($request->date_request)),
                    'application_id' => $request->application->id,
                    'application_name_th' => $request->application->name_th,
                    'application_name_en' => $request->application->name_en,
                    'application_admin' => $request->application->application_admin,
                    'type_request' => match ($request->type_request) {
                        'bug' => ['type' => 'Bug', 'values' => 'bug'],
                        'new_feature' => ['type' => 'New Feature', 'values' => 'new_feature'],
                        'improvement' => ['type' => 'Improvement', 'values' => 'improvement'],
                    },
                    'description' => $request->description,
                    'actor' => $request->RequestTimeline->last()->name ?? null,
                    'status_request' => match ($request->RequestTimeline->last()->status_request) {
                        'pending' => ['status' => 'Pending', 'values' => 'pending'],
                        'in_progress' => ['status' => 'In Progress', 'values' => 'in_progress'],
                        'completed' => ['status' => 'Completed', 'values' => 'completed'],
                        'rejected' => ['status' => 'Rejected', 'values' => 'rejected'],
                        'testing' => ['status' => 'Testing', 'values' => 'testing'],
                        'approved' => ['status' => 'Approved', 'values' => 'approved'],
                    },
                ];
            });

        $status = [
            ['values' => 'pending', 'name' => 'Pending'],
            ['values' => 'in_progress', 'name' => 'In Progress'],
            ['values' => 'completed', 'name' => 'Completed'],
            ['values' => 'rejected', 'name' => 'Rejected'],
            ['values' => 'testing', 'name' => 'Testing'],
            ['values' => 'approved', 'name' => 'Approved'],
        ];

        // dd($requests);


        return Inertia::render('RequestIndex', [
            'requests' => $requests,
            'status_request' => $status,
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
    public function show(ModelsRequest $request)
    {
        $request = ModelsRequest::query()
            ->where('id', $request->id)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'user_id' => $request->user_id,
                    'user_name' => $request->user->name,
                    'requester' => $request->requester,
                    'date_request' => date('d-m-Y', strtotime($request->date_request)),
                    'application_id' => $request->application->id,
                    'application_name_th' => $request->application->name_th,
                    'application_name_en' => $request->application->name_en,
                    'application_admin' => $request->application->application_admin,
                    'type_request' => match ($request->type_request) {
                        'bug' => ['type' => 'Bug', 'value' => 'bug'],
                        'new_feature' => ['type' => 'New Feature', 'value' => 'new_feature'],
                        'improvement' => ['type' => 'Improvement', 'value' => 'improvement'],
                    },
                    'description' => $request->description,
                    'actor' => $request->RequestTimeline->last()->name ?? null,
                    'status_request' => match ($request->RequestTimeline->last()->status_request) {
                        'pending' => ['status' => 'Pending', 'value' => 'pending'],
                        'in_progress' => ['status' => 'In Progress', 'value' => 'in_progress'],
                        'completed' => ['status' => 'Completed', 'value' => 'completed'],
                        'rejected' => ['status' => 'Rejected', 'value' => 'rejected'],
                        'testing' => ['status' => 'Testing', 'value' => 'testing'],
                        'approved' => ['status' => 'Approved', 'value' => 'approved'],
                    },
                ];
            })->first();

        // dd($request);

        return Inertia::render('RequestShow', [
            "request" => $request
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelsRequest $request)
    {
//        $request = [
//            'id' => $request->id,
//            'user_id' => $request->user_id,
//            'user_name' => $request->user->name,
//            'requester' => $request->requester,
//            'date_request' => date('Y-m-d', strtotime($request->date_request)),
//            'application_id' => $request->application->id,
//            'application_name_th' => $request->application->name_th,
//            'application_name_en' => $request->application->name_en,
//            'application_admin' => $request->application->application_admin,
//            'type_request' => match ($request->type_request) {
//                'bug' => ['type' => 'Bug', 'value' => 'bug'],
//                'new_feature' => ['type' => 'New Feature', 'value' => 'new_feature'],
//                'improvement' => ['type' => 'Improvement', 'value' => 'improvement'],
//            },
//            'description' => $request->description,
//            'actor' => $request->RequestTimeline->last()->name ?? null,
//            'status_request' => match ($request->RequestTimeline->last()->status_request) {
//                'pending' => ['status' => 'Pending', 'value' => 'pending'],
//                'in_progress' => ['status' => 'In Progress', 'value' => 'in_progress'],
//                'completed' => ['status' => 'Completed', 'value' => 'completed'],
//                'rejected' => ['status' => 'Rejected', 'value' => 'rejected'],
//                'testing' => ['status' => 'Testing', 'value' => 'testing'],
//                'approved' => ['status' => 'Approved', 'value' => 'approved'],
//            },
//        ];
        $request = ModelsRequest::query()
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'user_id' => $request->user_id,
                    'user_name' => $request->user->name,
                    'requester' => $request->requester,
                    'date_request' => date('d-m-Y', strtotime($request->date_request)),
                    'application_id' => $request->application->id,
                    'application_name_th' => $request->application->name_th,
                    'application_name_en' => $request->application->name_en,
                    'application_admin' => $request->application->application_admin,
                    'type_request' => match ($request->type_request) {
                        'bug' => ['type' => 'Bug', 'value' => 'bug'],
                        'new_feature' => ['type' => 'New Feature', 'value' => 'new_feature'],
                        'improvement' => ['type' => 'Improvement', 'value' => 'improvement'],
                    },
                    'description' => $request->description,
                    'actor' => $request->RequestTimeline->last()->name ?? null,
                    'status_request' => match ($request->RequestTimeline->last()->status_request) {
                        'pending' => ['status' => 'Pending', 'value' => 'pending'],
                        'in_progress' => ['status' => 'In Progress', 'value' => 'in_progress'],
                        'completed' => ['status' => 'Completed', 'value' => 'completed'],
                        'rejected' => ['status' => 'Rejected', 'value' => 'rejected'],
                        'testing' => ['status' => 'Testing', 'value' => 'testing'],
                        'approved' => ['status' => 'Approved', 'value' => 'approved'],
                    },
                ];
            })->first();
        // dd($request);

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
    public function update(UpdateRequestRequest $request, ModelsRequest $request_model)
    {
        dd($request->all(), $request_model);
        // ModelsRequest::where('id', $id)->update([
        //     'user_id' => $request->user_id,
        //     'requester' => $request->requester,
        //     'date_request' => $request->date_request,
        //     'application_id' => $request->application,
        //     'type_request' => $request->type_request,
        //     'description' => $request->description,
        // ]);

        // $request_model->fill($request);

        // if($request_model->isClean()) {
        //     return redirect()->route('request.index')->with([
        //     "intent" => "warning",
        //     'msg' => 'No changes were made to the request!',
        // ]);
        // }

        if ($request_model->isDirty()) {
            $request_model->save();

            ModelsRequest_Timeline::create([
                'name' => $request->actor,
                'status_request' => $request->status_request,
                'request_id' => $request_model->id,
            ]);

            return redirect()->route('request.index')->with([
                "intent" => "success",
                'msg' => 'Request updated successfully!',
            ]);
        } else {
            return redirect()->route('request.index')->with([
                "intent" => "warning",
                'msg' => 'No changes were made to the request!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function update_status(UpdateStatusRequest $request, string $id)
    {
        // dd($request->all(), $id);

        ModelsRequest_Timeline::create([
            'name' => $request->actor,
            'status_request' => $request->status_request,
            'request_id' => $id,
        ]);

        return redirect()->route('request.index')->with([
            "intent" => "success",
            'msg' => 'Request status updated successfully!',
        ]);
    }
    public function destroy(string $id)
    {
        //
    }
}
