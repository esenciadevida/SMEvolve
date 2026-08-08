<?php

namespace Database\Seeders;

use App\Models\AiConfiguration;
use Illuminate\Database\Seeder;

class AiConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'assistant.enabled' => ['value' => config('ai.assistant.enabled') ? '1' : '0', 'type' => 'boolean'],
            'quote.enabled' => ['value' => config('ai.quote.enabled') ? '1' : '0', 'type' => 'boolean'],
            'assistant.welcome_message' => ['value' => config('ai.assistant.welcome_message'), 'type' => 'string'],
            'assistant.availability_message' => ['value' => config('ai.assistant.availability_message'), 'type' => 'string'],
        ];

        foreach ($defaults as $key => $data) {
            AiConfiguration::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'type' => $data['type'],
                    'is_public' => true,
                    'updated_by' => 'system',
                ]
            );
        }
    }
}
