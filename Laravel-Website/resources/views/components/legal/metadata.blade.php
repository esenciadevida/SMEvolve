@props([
    'document' => [],
    'trail' => [],
])

@php
    $seo = config('seo');

    $webPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $document['meta']['title'] ?? $document['title'] ?? '',
        'url' => route($document['route'] ?? 'home'),
        'description' => $document['meta']['description'] ?? '',
    ];

    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $seo['organization']['name'] ?? config('app.name'),
        'url' => $seo['organization']['url'] ?? url('/'),
    ];

    if (filled($seo['organization']['logo'] ?? null)) {
        $organizationSchema['logo'] = url($seo['organization']['logo']);
    }

    foreach (['email', 'phone'] as $field) {
        if (filled($seo['organization'][$field] ?? null)) {
            $organizationSchema[$field] = $seo['organization'][$field];
        }
    }

    if (! empty($seo['organization']['social'])) {
        $organizationSchema['sameAs'] = array_values($seo['organization']['social']);
    }
@endphp

<script type="application/ld+json">
{!! json_encode($webPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode(\App\Support\Breadcrumbs::schema($trail), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
