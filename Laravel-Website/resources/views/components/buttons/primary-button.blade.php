@props(['href' => null, 'type' => 'button'])

<x-buttons.button variant="primary" :href="$href" :type="$type" {{ $attributes }}>
    {{ $slot }}
</x-buttons.button>
