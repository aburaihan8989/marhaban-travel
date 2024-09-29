<?php

namespace Modules\Package\Http\Controllers;

use Modules\Package\DataTables\HajjPackageDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Package\Entities\HajjPackage;
use Modules\Package\Http\Requests\StoreHajjPackageRequest;
use Modules\Package\Http\Requests\UpdateHajjPackageRequest;
use Modules\Upload\Entities\Upload;

class HajjPackageController extends Controller
{

    public function index(HajjPackageDataTable $dataTable) {
        // abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('package::hajj.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_products'), 403);

        return view('package::hajj.create');
    }


    public function store(Request $request) {
        $hajj_package = HajjPackage::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $hajj_package->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('brosurs');
            }
        }

        toast('Hajj Package Created!', 'success');

        return redirect()->route('hajj-packages.index');
    }


    public function show(HajjPackage $hajj_package) {
        // abort_if(Gate::denies('show_products'), 403);

        return view('package::hajj.show', compact('hajj_package'));
    }


    public function edit(HajjPackage $hajj_package) {
        // abort_if(Gate::denies('edit_products'), 403);

        return view('package::hajj.edit', compact('hajj_package'));
    }


    public function update(Request $request, HajjPackage $hajj_package) {
        $hajj_package->update($request->except('document'));

        if ($request->has('document')) {
            if (count($hajj_package->getMedia('brosurs')) > 0) {
                foreach ($hajj_package->getMedia('brosurs') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $hajj_package->getMedia('brosurs')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $hajj_package->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('brosurs');
                }
            }
        }

        toast('Hajj Package Updated!', 'info');

        return redirect()->route('hajj-packages.index');
    }


    public function destroy(HajjPackage $hajj_package) {
        // abort_if(Gate::denies('delete_products'), 403);

        $hajj_package->delete();

        toast('Hajj Package Deleted!', 'warning');

        return redirect()->route('hajj-packages.index');
    }


    // API Handling

    public function getHajjPackage() {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = HajjPackage::withCount('hajjCustomer')->where('package_status', 'Active')->get();

        return $data;
    }
}
