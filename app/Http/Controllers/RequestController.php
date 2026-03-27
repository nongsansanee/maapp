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
use BaconQrCode\Common\Mode;
use Dotenv\Util\Str;
use PhpParser\Node\Expr\AssignOp\Mod;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

use function PHPSTORM_META\map;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $filter)
    {
        // if($filter->filled('filter_type') || $filter->filled('filter_status')) {
        //      dd($filter);
        // }
        Log::Info('Clearing filters, current filter values: ' . json_encode($filter->all()));
        if ($filter->filled('filter_clear') && $filter->get('filter_clear') == 'true') {
            // $filter->replace([]);
            return redirect()->route('request.index')->with([
                "intent" => "success",
                'msg' => 'Filters cleared successfully!',
            ]);
            
        }
        $requests = ModelsRequest::query()
            ->when($filter->filled('filter_requester'), function ($query) {
                return  $query->where('requester', 'like', '%' . request('filter_requester') . '%');
            })
            ->when($filter->filled('filter_date_start') && $filter->filled('filter_date_end'), function ($query) {
                return  $query->whereBetween('date_request', [request('filter_date_start'), request('filter_date_end')]);
            })
            ->when($filter->filled('filter_type'), function ($query) {
                return  $query->where('type_request', request('filter_type'));
            })
            ->when($filter->filled('filter_app'), function ($query) {
                return  $query->whereHas('application', function ($query) {
                    $query->where('id', request('filter_app'));
                });
            })
            ->when($filter->filled('filter_admin'), function ($query) {
                return  $query->whereHas('application', function ($query) {
                    $query->where('application_admin', request('filter_admin'));
                });
            })
            ->when($filter->filled('filter_status'), function ($query) {
                //    dd($query);
                return  $query->whereHas('latestTimeline', function ($query) {
                    $query->where('status_request', request('filter_status'));
                });
            })
            ->paginate(5)->withQueryString()->through(function ($request) {
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
                    'hashed_key' => $request->hashed_key,
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
        $applications = Application::where('status', 1)->get();

        return Inertia::render('RequestIndex', [
            'applications' => $applications,
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
    // public function store(StoreRequestRequest $request)
    public function store(StoreRequestRequest $request)
    {
        // dd($request->all());

        try {

            DB::beginTransaction();

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

            // dd($Modelrequest, $Modelrequest->RequestTimeline);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        // $Modelrequest = ModelsRequest::create([
        //     'user_id' => $request->user_id,
        //     'requester' => $request->requester,
        //     'date_request' => $request->date_request,
        //     'application_id' => $request->application,
        //     'type_request' => $request->type_request,
        //     'description' => $request->description,
        //     'name' => $request->actor,
        //     'status_request' => $request->status_request,
        // ]);

        // ModelsRequest_Timeline::create([
        //     'request_id' => $Modelrequest->id,
        //     'name' => $request->actor,
        //     'status_request' => $request->status_request,
        // ]);

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
    public function show(String $hashed_key)
    {
        $hashed = new Hashids(config('app.key'), 5);
        $decoded_array = $hashed->decode($hashed_key);
        $decoded = $decoded_array[0] ?? null;
        $request = ModelsRequest::query()->find($decoded);

        // dd($request);
        $request_id = $request->id;

        $request =  [
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
            'created_at' => date('d-m-Y H:i:s', strtotime($request->created_at)),
        ];

        $request_timeline = ModelsRequest_Timeline::query()
            ->where('request_id', $request_id)
            ->get()
            ->map(function ($timeline) {
                return [
                    'id' => $timeline->id,
                    'name' => $timeline->name,
                    'status_request' => match ($timeline->status_request) {
                        'pending' => ['status' => 'Pending', 'value' => 'pending'],
                        'in_progress' => ['status' => 'In Progress', 'value' => 'in_progress'],
                        'completed' => ['status' => 'Completed', 'value' => 'completed'],
                        'rejected' => ['status' => 'Rejected', 'value' => 'rejected'],
                        'testing' => ['status' => 'Testing', 'value' => 'testing'],
                        'approved' => ['status' => 'Approved', 'value' => 'approved'],
                    },
                    'created_at' => date('d-m-Y H:i:s', strtotime($timeline->created_at)),
                ];
            });

        // dd($request , $request_timeline);

        return Inertia::render('RequestShow', [
            "request" => $request,
            "request_timeline" => $request_timeline
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(ModelsRequest $request)
    public function edit(String $hashed_key)
    {
        Log::Info('Edit request with hashed key: ' . $hashed_key);
        $hashed = new Hashids(config('app.key'), 5);
        $decoded_array = $hashed->decode($hashed_key);
        $decoded = $decoded_array[0] ?? null;
        $request = ModelsRequest::query()->find($decoded);


        $request_with_timeline = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'user_name' => $request->user->name,
            'requester' => $request->requester,
            'date_request' => date('Y-m-d', strtotime($request->date_request)),
            // 'date_request' => $request->date_request,
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
            'request_with_timeline' => $request_with_timeline,
            'type_request' => $type,
            'status_request' => $status,
            'applications' => $applications,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $update_request, ModelsRequest $model_request)
    // public function update(UpdateRequestRequest $update_request, string $id)
    {
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

        // $request_model = ModelsRequest::find($id)
        //     ->first();
        // dd($update_request->all(), $update_request);

        $validated = $update_request->validate([
            'user_id' => 'required',
            'requester' => 'required',
            'date_request' => 'required|date',
            'application_id' => 'required',
            // 'type_request' => 'required',
            'description' => 'required',
        ]);

        $validated['date_request'] = date('Y-m-d 00:00:00', strtotime($validated['date_request']));
        $model_request->fill($validated);

        if ($model_request->isClean()) {
            return back()->with([
                "intent" => "warning",
                'msg' => 'No changes were made to the request!',
            ]);
        } else {
            // dd($update_request->all(), $model_request);
            // dd($validated, $model_request, $model_request->getDirty(), $model_request->isClean());
            $model_request->save();

            if ($update_request->status_request->isDirty() || $update_request->actor->isDirty()) {
                ModelsRequest_Timeline::create([
                    'name' => $update_request->actor,
                    'status_request' => $update_request->status_request,
                    'request_id' => $model_request->id,
                ]);
            }

            return redirect()->route('request.index')->with([
                "intent" => "success",
                'msg' => 'Request updated successfully!',
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

        return back()->with([
            "intent" => "success",
            'msg' => 'Request status updated successfully!',
        ]);
    }
    public function destroy(ModelsRequest $model_request)
    {
        $model_request->delete();
        $model_request->RequestTimeline()->delete();
        // dd($model_request);
        // foreach (ModelsRequest_Timeline::where('request_id', $model_request->id)->get() as $timeline) {
        //     $timeline->delete();
        // }
        return back()->with([
            "intent" => "success",
            'msg' => 'Request deleted successfully!',
        ]);
    }
}


// page timeline เเต่ละ request จะมี timeline ของการเปลี่ยนสถานะ ?? requestShow
//