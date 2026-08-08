@props(['href' => null, 'type' => 'button'])

<x-buttons.button variant="secondary" :href="$href" :type="$type" {{ $attributes }}>
    {{ $slot }}
</x-buttons.button>
