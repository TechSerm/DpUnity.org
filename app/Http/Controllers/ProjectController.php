<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function show($projectId)
    {
        $project = Project::findOrFail($projectId);
        return view('projects.show', compact('project'));
    }

    public function showDonations($projectId)
    {
        $project = Project::findOrFail($projectId);
        $donations = $project->donations()->with('member')
            ->latest()
            ->paginate(15);

        return view('projects.donations', compact('project', 'donations'));
    }

    public function showExpenses($projectId)
    {
        $project = Project::findOrFail($projectId);
        $expenses = $project->expenses()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('projects.expenses', compact('project', 'expenses'));
    }

    public function showDetails($projectId)
    {
        $project = Project::findOrFail($projectId);
        return view('projects.details', compact('project'));
    }

    public function showReports($projectId)
    {
        $project = Project::findOrFail($projectId);
        
        $donations = $project->donations()
            ->latest()
            ->take(30)
            ->get();
        
        $expenses = $project->expenses()
            ->with('category')
            ->latest()
            ->take(30)
            ->get();

        return view('projects.report', compact('project', 'donations', 'expenses'));
    }

    public function showExpenseDetails($projectId, $expenseId)
    {
        $project = Project::findOrFail($projectId);
        $expense = $project->expenses()->findOrFail($expenseId);
        return view('projects.expense_details', compact('project', 'expense'));
    }
}
