<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::all();
        return Inertia::render('ApplicationIndex', compact('applications'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applications = Application::where('status', 1)->get();
        return Inertia::render('ApplicationCreate',
            ['applications'=>$applications]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request) : RedirectResponse
    {
        logger($request);
//        try{
//            $application = Application::query()->create($request->validated());
//        }catch (\Exception $exception){
//            logger($exception);
//            return back()->with(["intent" => "danger", "msg" => "เพิ่มข้อมูลไม่สำเร็จ เนื่องจาก {$exception->getMessage()}"]);
//        }

        return back()->with(["intent" => "success", "msg" => "เพิ่มข้อมูลเรียบร้อย"]);
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
//    public function edit(string $id)
//    {
//        //dd($id);
//        $application = Application::query()->find($id);
//        return Inertia::render('ApplicationEdit',['application'=>$application]);
//    }

    public function edit(Application $application)
    {
        return Inertia::render('ApplicationEdit',['application'=>$application]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'name_th' => 'required|max:50',
            'name_en' => 'required',
            'status' => 'required',
            'application_admin' => 'required',
        ]);
        $application->fill($validated);

        if ($application->isClean()) {
            return back()->with([
                'intent' => 'warning',
                'msg' => 'ไม่มีการแก้ไขข้อมูล'
            ]);
        }
        $application->save();

        return back()->with([
            'intent' => 'success',
            'msg' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);
       // dd($request->all());
       // dd($application);
//        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
      // dd($application);
        $application->delete();

        return back()->with([
            'intent' => 'success',
            'msg' => 'ลบข้อมูลเรียบร้อยแล้ว'
        ]);
    }
}
