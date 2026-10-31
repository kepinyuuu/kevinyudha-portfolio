<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\ContactMessage;
use App\Models\DesignWork;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $profile     = Profile::getInstance();
        $skills      = Skill::published()->get()->groupBy('category');
        $projects    = Project::published()->take(6)->get();
        $designWorks = DesignWork::published()->get();
        $categories  = $designWorks->pluck('category')->unique()->values();

        return view('portfolio.index', compact(
            'profile', 'skills', 'projects', 'designWorks', 'categories'
        ));
    }

    public function contact(ContactFormRequest $request): RedirectResponse
    {
        // Honeypot check
        if ($request->filled('website')) {
            return redirect()->route('home')->with('contact_success', true);
        }

        ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('home', ['#contact'])->with('contact_success', true);
    }
}
