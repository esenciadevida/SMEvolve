@php
    $contact = config('company.contact', []);
    $address = config('company.address', []);
    $maps = config('company.maps', []);
    $hours = config('company.hours', []);
    $socials = collect(config('social_links.platforms', []))->filter(fn ($platform) => ($platform['enabled'] ?? false) && filled($platform['href'] ?? null));

    $phone = $contact['phone'] ?? null;
    $email = $contact['email'] ?? null;
    $whatsapp = $contact['whatsapp'] ?? null;
    $location = $address['formatted'] ?? null;
    $directions = $maps['directions_url'] ?? null;
    $holidayNotice = $hours['holiday_notice'] ?? null;

    $responseTimes = $hours['response_times'] ?? [];

    $cards = collect([]);

    if (filled($phone)) {
        $cards->push([
            'icon' => 'phone',
            'title' => 'Phone',
            'description' => $responseTimes['phone']['value'] ?? 'Monday - Friday, 9:00 AM - 6:00 PM',
            'href' => 'tel:'.preg_replace('/\s+/', '', $phone),
            'action_label' => 'Call Now',
            'external' => false,
            'track' => 'contact:call',
        ]);
    }

    if (filled($email)) {
        $cards->push([
            'icon' => 'envelope',
            'title' => 'Email',
            'description' => $responseTimes['email']['value'] ?? 'Replies within one business day.',
            'href' => 'mailto:'.$email,
            'action_label' => 'Send Email',
            'external' => false,
            'track' => 'contact:email',
        ]);
    }

    if (filled($whatsapp)) {
        $cards->push([
            'icon' => 'chat-bubble-left-right',
            'title' => 'WhatsApp',
            'description' => $responseTimes['whatsapp']['value'] ?? 'Fastest way to reach us.',
            'href' => $whatsapp,
            'action_label' => 'Open WhatsApp',
            'external' => true,
            'track' => 'contact:whatsapp',
        ]);
    }

    if (filled($location)) {
        $cards->push([
            'icon' => 'map-pin',
            'title' => 'Office Location',
            'value' => $location,
            'description' => 'View our location and get directions.',
            'href' => $directions ?: '#map-and-service-area',
            'action_label' => $directions ? 'Get Directions' : 'View Map',
            'external' => (bool) $directions,
            'track' => 'contact:map',
        ]);
    }

    $cards->push([
        'icon' => 'clock',
        'title' => 'Business Hours',
        'value' => $hours['summary_string'] ?? null,
        'description' => $holidayNotice ?: 'We respond as soon as we are back online.',
        'href' => '#business-hours',
        'action_label' => 'View Hours',
        'external' => false,
        'track' => 'contact:hours',
    ]);

    if ($socials->isNotEmpty()) {
        $cards->push([
            'icon' => 'link',
            'title' => 'Social Media',
            'value' => $socials->pluck('label')->implode(' · '),
            'description' => 'Follow SMEvolve for updates and insights.',
            'href' => $socials->first()['href'],
            'action_label' => 'Follow Us',
            'external' => true,
            'track' => 'contact:social',
            'socials' => $socials->map(fn (array $platform) => [
                'platform' => $platform['platform'],
                'label' => $platform['label'],
                'href' => $platform['href'],
            ])->values(),
        ]);
    }

    $cards->push([
        'icon' => 'document-text',
        'title' => 'Get a Quote',
        'value' => 'Free, no-obligation pricing for your project.',
        'description' => 'Tell us what you need and we will prepare a tailored quote.',
        'href' => route('quote'),
        'action_label' => 'Request a Quote',
        'external' => false,
        'track' => 'contact:quote',
    ]);
@endphp

<x-sections.section
    id="contact-information"
    heading="Contact Information"
    description="Reach us through whichever channel suits you best, every method below is monitored and answered by our team."
    variant="surface"
>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($cards as $card)
            <x-cards.contact-card
                :icon="$card['icon']"
                :title="$card['title']"
                :value="$card['value'] ?? null"
                :description="$card['description']"
                :href="$card['href'] ?? null"
                :action-label="$card['action_label'] ?? null"
                :external="$card['external'] ?? false"
                :track="$card['track'] ?? null"
                :socials="$card['socials'] ?? []"
            />
        @endforeach
    </div>
</x-sections.section>
