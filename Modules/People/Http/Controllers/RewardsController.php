<?php

namespace Modules\People\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\People\Entities\Agent;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\People\DataTables\AgentsDataTable;
use Modules\People\DataTables\RewardsDataTable;
use Modules\People\DataTables\ShowAgentsDataTable;

class RewardsController extends Controller
{

    public function index(RewardsDataTable $dataTable) {
        // abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::agents.rewards.index');
    }


    public function show_agents(ShowAgentsDataTable $dataTable, $agent_id) {
        // abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::agents.rewards.show-agents');
    }

}
