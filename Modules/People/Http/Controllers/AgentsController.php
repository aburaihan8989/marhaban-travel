<?php

namespace Modules\People\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Modules\People\Entities\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\People\DataTables\AgentsDataTable;
use Modules\Manifest\Entities\UmrohManifestCustomer;

class AgentsController extends Controller
{

    public function index(AgentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::agents.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_customers'), 403);

        return view('people::agents.create');
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('create_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'agent_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'agent_phone' => 'required|max:255',
            // 'agent_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $agent = Agent::create([
            'nik_number'     => $request->nik_number,
            'agent_name'     => $request->agent_name,
            'date_birth'     => $request->date_birth,
            'agent_phone'    => $request->agent_phone,
            'bank_account'   => $request->bank_account,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'agent_email'    => $request->agent_email,
            'gender'         => $request->gender,
            'referal_id'     => $request->referal_id,
            'level_agent'    => $request->level_agent,
            'agent_status'   => $request->agent_status,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            foreach ($request->input('document') as $file) {
                $agent->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('agents');
            }
        }

        toast('Agent Created!', 'success');

        return redirect()->route('agents.index');
    }


    public function show(Agent $agent) {
        // abort_if(Gate::denies('show_customers'), 403);
        $referal_agent = Agent::findOrFail($agent->referal_id);

        return view('people::agents.show', compact('agent', 'referal_agent'));
    }


    public function edit(Agent $agent) {
        // abort_if(Gate::denies('edit_customers'), 403);
        $referal_agent = Agent::findOrFail($agent->referal_id);

        return view('people::agents.edit', compact('agent', 'referal_agent'));
    }


    public function update(Request $request, Agent $agent) {
        // abort_if(Gate::denies('update_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'agent_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'agent_phone' => 'required|max:255',
            // 'agent_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $agent->update([
            'nik_number'     => $request->nik_number,
            'agent_name'     => $request->agent_name,
            'date_birth'     => $request->date_birth,
            'agent_phone'    => $request->agent_phone,
            'bank_account'   => $request->bank_account,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'agent_email'    => $request->agent_email,
            'gender'         => $request->gender,
            'level_agent'    => $request->level_agent,
            'referal_id'     => $request->referal_id,
            'agent_status'   => $request->agent_status,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            if (count($agent->getMedia('agents')) > 0) {
                foreach ($agent->getMedia('agents') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $agent->getMedia('agents')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $agent->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('agents');
                }
            }
        }

        toast('Agent Updated!', 'info');

        return redirect()->route('agents.index');
    }


    public function destroy(Agent $agent) {
        // abort_if(Gate::denies('delete_customers'), 403);

        $agent->delete();

        toast('Agent Deleted!', 'warning');

        return redirect()->route('agents.index');
    }


    // API Handling

    public function getAgent($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = Agent::findOrFail($agent_id);
        $referal = Agent::findOrFail($data->referal_id);
        $data['referal_code'] = $referal->agent_code;
        $data['referal_name'] = $referal->agent_name;

        return $data;
    }


    public function getAgentNetwork($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('agents')
                ->leftjoin('umroh_manifest_customers', 'agents.id', '=', 'umroh_manifest_customers.agent_id')
                ->select('agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'agents.city',
                         'agents.level_agent',
                         'agents.id as referal_id',
                        //  'agents.total_reward as total_reward',
                         DB::raw('count(umroh_manifest_customers.agent_id) as customer_count'),
                         DB::raw('sum(umroh_manifest_customers.referal_reward) as total_reward')
                        )
                ->where('referal_id', '=', $agent_id)
                ->groupBy('agents.id')
                ->get();

        return $data;
    }


    // Customers Network

    public function getUmrohCustomers($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('umroh_manifest_customers')
                ->where('agent_id', $agent_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.id',
                         'umroh_manifest_customers.reference',
                         'umroh_manifest_customers.agent_reward',
                         'umroh_manifest_customers.promo',
                         'umroh_manifest_customers.promo2',
                         'umroh_manifest_customers.mark',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->get();

        return $data;
    }


    public function getHajjCustomers($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('hajj_manifest_customers')
                ->where('agent_id', $agent_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('hajj_packages', 'package_id', '=','hajj_packages.id')
                ->select('hajj_manifest_customers.id',
                         'hajj_manifest_customers.reference',
                         'hajj_manifest_customers.agent_reward',
                         'hajj_manifest_customers.promo',
                         'hajj_manifest_customers.promo2',
                         'hajj_manifest_customers.mark',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'hajj_packages.package_name'
                         )
                ->get();

        return $data;
    }


    public function getUmrohSavingCustomers($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('savings')
                ->where('agent_id', $agent_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->select('savings.id',
                         'savings.register_date',
                         'savings.reference',
                         'savings.customer_bank',
                         'savings.bank_account',
                         'savings.total_saving',
                         'savings.status',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone'
                         )
                ->get();

        return $data;
    }


    public function getHajjSavingCustomers($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('hajj_savings')
                ->where('agent_id', $agent_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->select('hajj_savings.id',
                         'hajj_savings.register_date',
                         'hajj_savings.reference',
                         'hajj_savings.customer_bank',
                         'hajj_savings.bank_account',
                         'hajj_savings.total_saving',
                         'hajj_savings.status',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone'
                         )
                ->get();

        return $data;
    }


    public function markUmrohCustomer($customer_id) {
        // abort_if(Gate::denies('update_customers'), 403);

        $data = DB::table('umroh_manifest_customers')
                ->where('id', $customer_id)
                ->update(['mark' => 1]);

    }


    public function markHajjCustomer($customer_id) {
        // abort_if(Gate::denies('update_customers'), 403);

        $data = DB::table('hajj_manifest_customers')
                ->where('id', $customer_id)
                ->update(['mark' => 1]);

    }


    public function getPotentialUmrohCustomers($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('umroh_manifest_customers')
                ->where('agent_id', $agent_id)
                ->where('mark', 1)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.id',
                         'umroh_manifest_customers.reference',
                         'umroh_manifest_customers.agent_reward',
                         'umroh_manifest_customers.promo',
                         'umroh_manifest_customers.promo2',
                         'umroh_manifest_customers.rating',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->get();

        return $data;
    }


    public function getUmrohCustomer($customer_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        // $data = UmrohManifestCustomer::findOrFail($customer_id);
        $data = DB::table('umroh_manifest_customers')
                ->where('umroh_manifest_customers.id', $customer_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.id',
                         'umroh_manifest_customers.reference',
                         'umroh_manifest_customers.rating',
                         'umroh_manifest_customers.fu_notes',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->first();

        return $data;
    }


    public function postPoinUmrohCustomer($customer_id, Request $request) {
        // abort_if(Gate::denies('update_customers'), 403);
        // @dd($request);
        $data = DB::table('umroh_manifest_customers')
                ->where('id', $customer_id)
                ->update(['rating' => $request->rating, 'fu_notes' => $request->fu_notes]);

    }


    public function getCustomerReferalNetwork($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('umroh_manifest_customers')
                ->where('agent_id', $agent_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.reference',
                         'umroh_manifest_customers.referal_reward',
                         'umroh_manifest_customers.promo',
                         'umroh_manifest_customers.promo2',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->get();

        return $data;
    }


    public function getCountAgentNetwork($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = Agent::where('referal_id', $agent_id)->count();

        return $data;
    }


    public function getCountCustomerNetwork($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = UmrohManifestCustomer::where('agent_id', $agent_id)->count();

        return $data;
    }


    public function getCountPotentialCustomer($agent_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = UmrohManifestCustomer::where([['agent_id', $agent_id],['mark', 1]])->count();

        return $data;
    }


    public function getActivityAgent() {
        // abort_if(Gate::denies('access_customers'), 403);
        $getdata = Http::get(settings()->api_url . 'api/activity-agent');
        $data = $getdata->json();

        return view('people::agents.activity.data', compact('data'));
    }


    public function editActivityAgent($activity_id) {
        // abort_if(Gate::denies('edit_customers'), 403);

        $getdata = Http::get(settings()->api_url . 'api/activity-agent/' . $activity_id);
        $activity = $getdata->json();

        return view('people::agents.activity.edit', compact('activity'));
    }


    public function updateActivityAgent($activity_id, Request $request) {
        // abort_if(Gate::denies('update_customers'), 403);
        $postdata = Http::post(settings()->api_url . 'api/activity-agent/' . $activity_id, $request->input());

        toast('Agent Activity Updated!', 'info');

        return redirect()->route('activity-agent.data');
    }


}
