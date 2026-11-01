<?php

namespace App\Http\Controllers;

use Illuminate\Support\Fluent;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        // 1. Profil dari config/portfolio.php
        $cfgProfile = config('portfolio.profile', []);
        $profileData = [];
        foreach ($cfgProfile as $key => $val) {
            $profileData[$key] = ($val === 'ISI' || blank($val)) ? null : $val;
        }
        $profile = new Fluent($profileData);

        // 2. Skills dari config/portfolio.php
        $skills = collect(config('portfolio.skills', []))
            ->filter(fn ($s) => isset($s['name']) && $s['name'] !== 'ISI' && filled($s['name']))
            ->map(fn ($s) => new Fluent([
                'name'         => $s['name'],
                'category'     => ($s['category'] ?? '') === 'ISI' ? 'general' : ($s['category'] ?? 'general'),
                'level'        => 80,
                'sort_order'   => is_numeric($s['sort_order'] ?? null) ? (int)$s['sort_order'] : 0,
                'is_published' => true,
            ]))
            ->groupBy('category');

        // 3. Projects dari config/portfolio.php
        $projects = collect(config('portfolio.projects', []))
            ->filter(fn ($p) => isset($p['title']) && $p['title'] !== 'ISI' && filled($p['title']))
            ->map(function ($p) {
                $summary = ($p['summary'] ?? $p['description'] ?? '') === 'ISI' ? '' : ($p['summary'] ?? $p['description'] ?? '');
                $tags = is_array($p['tags'] ?? null) ? $p['tags'] : [];
                $cover = ($p['cover'] ?? $p['image'] ?? '') === 'ISI' ? null : ($p['cover'] ?? $p['image'] ?? null);

                return new Fluent([
                    'title'              => $p['title'],
                    'description'        => $summary,
                    'summary'            => $summary,
                    'role'               => $p['role'] ?? 'UI/UX Designer',
                    'technologies'       => implode(', ', $tags),
                    'technologies_array' => $tags,
                    'tags'               => $tags,
                    'image'              => $cover,
                    'cover'              => $cover,
                    'demo_url'           => ($p['demo_url'] ?? '') === 'ISI' ? null : ($p['demo_url'] ?? null),
                    'github_url'         => ($p['github_url'] ?? '') === 'ISI' ? null : ($p['github_url'] ?? null),
                    'gallery'            => $p['gallery'] ?? [],
                    'points'             => $p['points'] ?? [],
                    'is_featured'        => filter_var($p['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'is_published'       => true,
                    'sort_order'         => is_numeric($p['sort_order'] ?? null) ? (int)$p['sort_order'] : 0,
                ]);
            });

        // 4. Design Works dari config/portfolio.php
        $designWorks = collect(config('portfolio.design_works', []))
            ->filter(fn ($w) => isset($w['title']) && $w['title'] !== 'ISI' && filled($w['title']))
            ->map(fn ($w) => new Fluent([
                'title'        => $w['title'],
                'category'     => ($w['category'] ?? '') === 'ISI' ? 'Design' : ($w['category'] ?? 'Design'),
                'image'        => ($w['image'] ?? '') === 'ISI' ? '' : ($w['image'] ?? ''),
                'description'  => ($w['description'] ?? '') === 'ISI' ? null : ($w['description'] ?? null),
                'is_published' => true,
                'sort_order'   => is_numeric($w['sort_order'] ?? null) ? (int)$w['sort_order'] : 0,
            ]));

        $categories = $designWorks->pluck('category')->unique()->values();
        $languages  = config('portfolio.languages', []);
        $nav        = config('portfolio.navigation', []);

        return view('portfolio.index', compact(
            'profile', 'skills', 'projects', 'designWorks', 'categories', 'languages', 'nav'
        ));
    }
}
