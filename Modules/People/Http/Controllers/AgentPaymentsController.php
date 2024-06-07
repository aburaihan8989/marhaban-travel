<?php

namespace Modules\People\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Illuminate\Support\Facades\Storage;
use Modules\People\Entities\AgentPayment;
use Illuminate\Contracts\Support\Renderable;
use Modules\People\DataTables\AgentPaymentsDataTable;

class AgentPaymentsController extends Controller
{

    public function index($agent_id, AgentPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $agent = Agent::findOrFail($agent_id);

        return $dataTable->render('people::agents.payments.index', compact('agent'));
    }


    public function create($agent_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $agent = Agent::findOrFail($agent_id);

        return view('people::agents.payments.create', compact('agent'));
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request) {

            $agentPayment = AgentPayment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'trx_type' => $request->trx_type,
                'status' => 'Approval',
                'note' => $request->note,
                'agent_id' => $request->agent_id,
                'payment_method' => $request->payment_method
            ]);

            if ($request->has('document')) {
                foreach ($request->input('document', []) as $file) {
                    $agentPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('rewards');
                }
            }

            $agent = Agent::findOrFail($request->agent_id);
            $paid_reward = $agent->paid_reward + $request->amount;

            $agent->update([
                'paid_reward' => $paid_reward
            ]);
        });

        toast('Agent Rewards Payment Created!', 'success');

        return redirect()->route('rewards.index');
    }


    public function edit($agent_id, AgentPayment $agentPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $agent = Agent::findOrFail($agent_id);

        return view('people::agents.payments.edit', compact('agentPayment', 'agent'));
    }


    public function update(Request $request, AgentPayment $agentPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request, $agentPayment) {
            $agent = $agentPayment->agents;

            $agent->update([
                'paid_reward' => ($agent->paid_reward - $agentPayment->amount) + $request->amount
            ]);

            $agentPayment->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'status' => $request->status,
                'agent_id' => $request->agent_id,
                'payment_method' => $request->payment_method
            ]);

            if ($request->has('document')) {
                if (count($agentPayment->getMedia('rewards')) > 0) {
                    foreach ($agentPayment->getMedia('rewards') as $media) {
                        if (!in_array($media->file_name, $request->input('document', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $agentPayment->getMedia('rewards')->pluck('file_name')->toArray();

                foreach ($request->input('document', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $agentPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('rewards');
                    }
                }
            }

        });

        toast('Agent Rewards Payment Updated!', 'info');

        return redirect()->route('agent-payments.index', $agentPayment->agent_id);
    }


    public function view($agent_id, AgentPayment $agentPayment) {
        // abort_if(Gate::denies('show_products'), 403);
        $agent = Agent::findOrFail($agent_id);
        // $customer = Customer::findOrFail($umroh_saving->customer_id);

        return view('people::agents.payments.view', compact('agentPayment', 'agent'));
    }


    public function destroy(AgentPayment $agentPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($agentPayment) {
            $agent = $agentPayment->agents;

            $agent->update([
                'paid_reward' => $agent->paid_reward - $agentPayment->amount
            ]);
        });

        $agentPayment->delete();

        toast('Agent Rewards Payment Deleted!', 'warning');

        return redirect()->route('agent-payments.index', $agentPayment->agent_id);
    }
}
