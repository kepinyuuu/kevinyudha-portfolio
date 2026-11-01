<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\DesignWork;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $profile     = null;
        $skills      = collect();
        $projects    = collect();
        $designWorks = collect();

        // 1. Coba baca dari Database jika ada
        try {
            $profile     = Profile::first();
            $skills      = Skill::published()->get()->groupBy('category');
            $projects    = Project::published()->take(6)->get();
            $designWorks = DesignWork::published()->get();
        } catch (\Throwable $e) {
            // Mode deploy tanpa DB
        }

        // 2. Fallback Profil ke config/portfolio.php
        if (! $profile || blank($profile->name)) {
            $cfgProfile = config('portfolio.profile', []);
            $profileData = [];
            foreach ($cfgProfile as $key => $val) {
                $profileData[$key] = ($val === 'ISI' || blank($val)) ? null : $val;
            }
            $profile = new Profile($profileData);
        }

        // 3. Fallback Skills ke config/portfolio.php
        if ($skills->isEmpty()) {
            $cfgSkills = collect(config('portfolio.skills', []))
                ->filter(fn ($s) => isset($s['name']) && $s['name'] !== 'ISI' && filled($s['name']))
                ->map(fn ($s) => new Skill([
                    'name'         => $s['name'],
                    'category'     => ($s['category'] ?? '') === 'ISI' ? 'general' : ($s['category'] ?? 'general'),
                    'level'        => 80,
                    'sort_order'   => is_numeric($s['sort_order'] ?? null) ? (int)$s['sort_order'] : 0,
                    'is_published' => true,
                ]))
                ->groupBy('category');

            if ($cfgSkills->isNotEmpty()) {
                $skills = $cfgSkills;
            }
        }

        // 4. Fallback Projects ke config/portfolio.php
        if ($projects->isEmpty()) {
            $cfgProjects = collect(config('portfolio.projects', []))
                ->filter(fn ($p) => isset($p['title']) && $p['title'] !== 'ISI' && filled($p['title']))
                ->map(function ($p) {
                    $proj = new Project([
                        'title'        => $p['title'],
                        'description'  => ($p['summary'] ?? $p['description'] ?? '') === 'ISI' ? '' : ($p['summary'] ?? $p['description'] ?? ''),
                        'technologies' => is_array($p['tags'] ?? null) ? implode(', ', $p['tags']) : (($p['technologies'] ?? '') === 'ISI' ? '' : ($p['technologies'] ?? '')),
                        'image'        => ($p['cover'] ?? $p['image'] ?? '') === 'ISI' ? null : ($p['cover'] ?? $p['image'] ?? null),
                        'demo_url'     => ($p['demo_url'] ?? '') === 'ISI' ? null : ($p['demo_url'] ?? null),
                        'github_url'   => ($p['github_url'] ?? '') === 'ISI' ? null : ($p['github_url'] ?? null),
                        'is_featured'  => filter_var($p['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'is_published' => true,
                        'sort_order'   => is_numeric($p['sort_order'] ?? null) ? (int)$p['sort_order'] : 0,
                    ]);
                    $proj->role = $p['role'] ?? 'UI/UX Designer';
                    $proj->summary = $p['summary'] ?? $p['description'] ?? '';
                    $proj->tags = is_array($p['tags'] ?? null) ? $p['tags'] : $proj->technologies_array;
                    $proj->cover = $p['cover'] ?? $p['image'] ?? null;
                    $proj->gallery = $p['gallery'] ?? [];
                    $proj->points = $p['points'] ?? [];
                    return $proj;
                });

            if ($cfgProjects->isNotEmpty()) {
                $projects = $cfgProjects;
            }
        }

        // 5. Fallback Design Works
        if ($designWorks->isEmpty()) {
            $cfgWorks = collect(config('portfolio.design_works', []))
                ->filter(fn ($w) => isset($w['title']) && $w['title'] !== 'ISI' && filled($w['title']))
                ->map(fn ($w) => new DesignWork([
                    'title'        => $w['title'],
                    'category'     => ($w['category'] ?? '') === 'ISI' ? 'Design' : ($w['category'] ?? 'Design'),
                    'image'        => ($w['image'] ?? '') === 'ISI' ? '' : ($w['image'] ?? ''),
                    'description'  => ($w['description'] ?? '') === 'ISI' ? null : ($w['description'] ?? null),
                    'is_published' => true,
                    'sort_order'   => is_numeric($w['sort_order'] ?? null) ? (int)$w['sort_order'] : 0,
                ]));

            if ($cfgWorks->isNotEmpty()) {
                $designWorks = $cfgWorks;
            }
        }

        $categories = $designWorks->pluck('category')->unique()->values();
        $languages  = config('portfolio.languages', []);
        $nav        = config('portfolio.navigation', []);

        return view('portfolio.index', compact(
            'profile', 'skills', 'projects', 'designWorks', 'categories', 'languages', 'nav'
        ));
    }

    public function contact(ContactFormRequest $request): Response
    {
        // Anti-spam honeypot (ditolak jika bot mengisi input honeypot)
        if ($request->filled('website')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Spam terdeteksi.',
                ], 422);
            }
            return redirect()->to(route('home') . '#contact')
                ->withErrors(['website' => 'Spam terdeteksi.'])
                ->withInput();
        }

        $directEmail = config('portfolio.profile.email', 'kepinyud67@gmail.com');
        $targetMail = config('mail.to_address')
            ?: config('portfolio.profile.mail_to_address')
            ?: $directEmail;

        try {
            if (empty($targetMail)) {
                throw new \RuntimeException('Alamat tujuan email belum dikonfigurasi.');
            }

            Mail::to($targetMail)->send(new ContactMessageMail(
                senderName: (string) $request->input('name'),
                senderEmail: (string) $request->input('email'),
                messageSubject: (string) $request->input('subject'),
                messageBody: (string) $request->input('message'),
            ));

            $successMessage = 'Pesan terkirim, terima kasih. Saya akan membalas secepatnya.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                ]);
            }

            return redirect()->to(route('home') . '#contact')->with('contact_success', $successMessage);
        } catch (\Throwable $e) {
            // Catat ke log tanpa mencatat data sensitif pengguna
            Log::error('Gagal mengirim email kontak: ' . get_class($e) . ' - ' . $e->getCode());

            $errorMessage = 'Maaf, terjadi kendala saat mengirim pesan. Silakan coba lagi atau kirim langsung ke ' . $directEmail . '.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            return redirect()->to(route('home') . '#contact')
                ->withInput()
                ->with('contact_error', $errorMessage);
        }
    }
}
