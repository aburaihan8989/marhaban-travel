<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Package\Entities\HajjPackage;
use Modules\Manifest\Entities\HajjManifest;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\DataTables\HajjManifestDataTable;
use Modules\Manifest\DataTables\HajjManifestCustomerDataTable;
use Modules\Manifest\DataTables\HajjManifestCustomerDetailDataTable;

class HajjManifestController extends Controller
{

    public function index(HajjManifestDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('manifest::hajj.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_purchases'), 403);

        return view('manifest::hajj.create');
    }

    public function store(Request $request) {
        DB::transaction(function () use ($request) {
            // $total_payment = $request->last_amount;
            // $remaining_payment = $request->total_price - $total_payment;

            // if ($total_payment >= $request->total_price) {
            //     $status = 'Completed';
            // } else {
            //     $status = 'Process';
            // }

            $hajj_manifest = HajjManifest::create([
                'register_date' => now()->format('Y-m-d'),
                'package_id' => $request->package_id,
                'package_code' => HajjPackage::findOrFail($request->package_id)->package_code,
                'package_name' => HajjPackage::findOrFail($request->package_id)->package_name,
                'package_date' => HajjPackage::findOrFail($request->package_id)->package_date,
                'package_departure' => HajjPackage::findOrFail($request->package_id)->package_departure,
                'flight_route' => HajjPackage::findOrFail($request->package_id)->flight_route,
                'package_days' => HajjPackage::findOrFail($request->package_id)->package_days,
                // 'customer_id' => $request->customer_id,
                // 'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                // // 'paspor_number' => Customer::findOrFail($request->customer_id)->paspor_number,
                'status' => $request->status,
                // 'customer_bank' => $request->customer_bank,
                // 'bank_account' => $request->bank_account,
                // 'total_price' => $request->total_price,
                // 'total_payment' => $total_payment,
                // 'remaining_payment' => $remaining_payment,
                // 'last_date' => now()->format('Y-m-d'),
                // 'last_amount' => $request->last_amount,
                // 'payment_method' => $request->payment_method,
                'note' => $request->note
            ]);

            // if ($umroh_manifest->last_amount > 0) {
            //     UmrohManifestPayment::create([
            //         'date' => now()->format('Y-m-d'),
            //         'reference' => 'INV/'.$umroh_manifest->reference,
            //         'amount' => $request->last_amount,
            //         'umroh_manifest_id' => $umroh_manifest->id,
            //         'payment_method' => $request->payment_method
            //     ]);
            // }
        });

        toast('Hajj Manifest Created!', 'success');

        return redirect()->route('hajj-manifests.index');
    }


    public function show(HajjManifest $hajj_manifest, HajjManifestCustomerDetailDataTable $dataTable) {
        // abort_if(Gate::denies('show_purchases'), 403);

        // $customer = Customer::findOrFail($umroh_manifest->customer_id);
        return $dataTable->render('manifest::hajj.show', compact('hajj_manifest'));

        // return view('manifest::umroh.show', compact('umroh_manifest'));
    }

    public function manage(HajjManifest $hajj_manifest, HajjManifestCustomerDataTable $dataTable) {
        // abort_if(Gate::denies('show_purchases'), 403);

        // $umroh_package = UmrohPackage::findOrFail($package_id);
        return $dataTable->render('manifest::hajj.manage', compact('hajj_manifest'));

        // return view('manifest::umroh.manage', compact('umroh_manifest'));
    }


    public function edit(HajjManifest $hajj_manifest) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('manifest::hajj.edit', compact('hajj_manifest'));
    }


    public function update(Request $request, HajjManifest $hajj_manifest) {

        $request->validate([
            // 'total_price' => 'required|numeric',
            // 'total_payment' => 'required|numeric',
            // 'remaining_payment' => 'required|numeric',
            'note' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $hajj_manifest) {
            // $total_payment = $request->total_payment + $request->last_amount;
            // $remaining_payment = $request->total_price - $request->total_payment;

            // if ($request->total_payment >= $request->total_price) {
            //     $status = 'Completed';
            // } else {
            //     $status = 'Process';
            // }

            $hajj_manifest->update([
                // 'register_date' => $request->register_date,
                'package_id' => $request->package_id,
                'package_code' => HajjPackage::findOrFail($request->package_id)->package_code,
                'package_name' => HajjPackage::findOrFail($request->package_id)->package_name,
                'package_date' => HajjPackage::findOrFail($request->package_id)->package_date,
                'package_departure' => HajjPackage::findOrFail($request->package_id)->package_departure,
                'flight_route' => HajjPackage::findOrFail($request->package_id)->flight_route,
                'package_days' => HajjPackage::findOrFail($request->package_id)->package_days,
                // 'customer_id' => $request->customer_id,
                // 'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                // 'paspor_number' => Customer::findOrFail($request->customer_id)->paspor_number,
                'status' => $request->status,
                // 'total_price' => $request->total_price,
                // 'total_payment' => $request->total_payment,
                // 'remaining_payment' => $remaining_payment,
                'note' => $request->note
            ]);

        });

        toast('Hajj Manifest Updated!', 'info');

        return redirect()->route('hajj-manifests.index');
    }


    public function destroy(HajjManifest $hajj_manifest) {
        // abort_if(Gate::denies('delete_purchases'), 403);

        $hajj_manifest->delete();

        toast('Hajj Manifest Deleted!', 'warning');

        return redirect()->route('hajj-manifests.index');
    }
}
