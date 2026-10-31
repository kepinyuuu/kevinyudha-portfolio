<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Portfolio Kevin Yudha Pratama — UI/UX Designer & Developer' }}">
    <meta property="og:title" content="{{ $title ?? 'Kevin Yudha Pratama' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Portfolio Kevin Yudha Pratama — UI/UX Designer & Developer' }}">
    <meta property="og:type" content="website">
    <title>{{ $title ?? 'Kevin Yudha Pratama — Portfolio' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-charcoal antialiased">
    {{ $slot }}
    @stack('scripts')
</body>
</html>
