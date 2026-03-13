<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcurementDashboardController extends Controller
{
    /**
     * Procurement overview.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('procurement.overviewdashboard');
    }

    /**
     * Approve proposals step.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function step1()
    {
        return view('procurement.step1dashboard');
    }

    /**
     * BAC processing step.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function step2()
    {
        return view('procurement.step2dashboard');
    }

    /**
     * Sign PR step.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function step3()
    {
        return view('procurement.step3dashboard');
    }
}
