<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('welcome', compact('services'));
    }

    public function store(Request $request)
    {
        $service = Service::create($request->all());
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return response()->json($service);
    }

    public function destroy($id)
    {
        Service::destroy($id);
        return response()->json(['success' => true]);
    }
}
