<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DesignWork;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'projects'       => Project::count(),
            'skills'         => Skill::count(),
            'design_works'   => DesignWork::count(),
            'messages_total' => ContactMessage::count(),
            'messages_unread'=> ContactMessage::unread()->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }
}
