<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Invite;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Counts by survey status
        $surveysCountByStatus = Survey::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Total counts
        $questionsCount = Question::count();
        $invitesCount = Invite::count();

        return view('dashboard', compact(
            'surveysCountByStatus',
            'questionsCount',
            'invitesCount'
        ));
    }
}
