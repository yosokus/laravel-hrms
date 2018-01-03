<?php

namespace RPSEMS\Http\Controllers;

use Illuminate\Http\Response;

class DashboardController extends Controller {

    /**
     * Constructor.
     */
    public function __construct() {
        view()->share('activeMenuDashboard', TRUE);
    }

    /**
     * @return Response
     */
    public function index() {
        return view('dashboard.index');
    }
}
