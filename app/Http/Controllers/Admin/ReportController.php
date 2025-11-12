<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Models\Exam;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {
        // $this->middleware('admin');
    }

    public function index()
    {
        $results = $this->reportService->getAllResults();
        return view('admin.reports.index', compact('results'));
    }

    public function examStatistics(Exam $exam)
    {
        $statistics = $this->reportService->getExamStatistics($exam->id);
        return view('admin.reports.exam-statistics', $statistics);
    }
}