<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Homework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        
        $exams = Exam::whereHas('users', function (Builder $query) {
            $query->where('user_id', Auth()->id());
        })->get();
        $homework = Homework::where('user_id', auth()->id());
        return view('dashboard.index', compact('exams', 'homework'));

    }
}
