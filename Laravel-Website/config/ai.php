<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI System Configuration
    |--------------------------------------------------------------------------
    |
    | Central configuration for the SMEvolve AI system. Provider credentials
    | are loaded from the environment only and must never be exposed to the
    | browser, Blade templates, or API responses.
    |
    */

    'provider' => env('AI_PROVIDER', 'groq'),

    /*
    | Global switch. When false, all public AI functionality is disabled.
    | The rest of the website keeps working normally.
    */
    'enabled' => env('AI_ENABLED', true),

    'assistant' => [
        'enabled' => env('AI_ASSISTANT_ENABLED', true),
        'welcome_message' => env('AI_WELCOME_MESSAGE', "Hi, I'm the SMEvolve AI Assistant. I can help you explore our services, answer questions, or start a quote. How can I help?"),
        'availability_message' => env('AI_AVAILABILITY_MESSAGE', 'Our AI Assistant is temporarily unavailable. You can still contact the SMEvolve team or request a quote.'),
    ],

    'quote' => [
        'enabled' => env('AI_QUOTE_ENABLED', true),
    ],

    'quote_feature_suggestions' => [
        'enabled' => env('AI_QUOTE_ENABLED', true),
    ],

    'quote_description_assistance' => [
        'enabled' => env('AI_QUOTE_ENABLED', true),
    ],

    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
        'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
        'base_url' => env('GROQ_BASE_URL', 'https://api.groq.com/openai/v1'),
        'timeout' => (int) env('GROQ_TIMEOUT', 30),
        'max_output_tokens' => (int) env('GROQ_MAX_OUTPUT_TOKENS', 1024),
        'temperature' => (float) env('GROQ_TEMPERATURE', 0.3),
        // Approved models an administrator may select. The API key and other
        // credentials are never exposed through the Admin Portal.
        'approved_models' => [
            'llama-3.3-70b-versatile' => 'Llama 3.3 70B Versatile',
            'llama-3.1-8b-instant' => 'Llama 3.1 8B Instant',
        ],
    ],

    'limits' => [
        'max_message_length' => (int) env('AI_MAX_MESSAGE_LENGTH', 4000),
        'max_context_messages' => (int) env('AI_MAX_CONTEXT_MESSAGES', 15),
        'max_requests_per_session' => (int) env('AI_MAX_REQUESTS_PER_SESSION', 60),
        'conversation_retention_days' => (int) env('AI_CONVERSATION_RETENTION_DAYS', 30),
    ],

    'rate_limits' => [
        'create_conversation' => (int) env('AI_RATE_LIMIT_CONVERSATIONS', 10),
        'send_message' => (int) env('AI_RATE_LIMIT_MESSAGES', 10),
        'quote_analyze' => (int) env('AI_RATE_LIMIT_QUOTE_ANALYZE', 5),
        'quote_ai_assist' => (int) env('AI_RATE_LIMIT_QUOTE_AI_ASSIST', 8),
        'quote_steps' => (int) env('QUOTE_RATE_LIMIT_STEPS', 30),
        'quote_submit' => (int) env('QUOTE_RATE_LIMIT_SUBMIT', 3),
        'quote_sessions' => (int) env('AI_RATE_LIMIT_QUOTE_SESSIONS', 10),
        'quote_answers' => (int) env('AI_RATE_LIMIT_QUOTE_ANSWERS', 30),
        'quote_submit_api' => (int) env('AI_RATE_LIMIT_QUOTE_SUBMIT_API', 3),
        'handoffs' => (int) env('AI_RATE_LIMIT_HANDOFFS', 3),
        'decay_minutes' => 1,
    ],

    'admin' => [
        'enabled' => env('AI_ADMIN_ENABLED', true),
        'email' => env('AI_ADMIN_EMAIL', 'admin@smevolve.tech'),
        'password' => env('AI_ADMIN_PASSWORD'),
        'session_key' => 'smevolve_admin_authenticated',
        'login_rate_limit' => 5,
    ],

    'usage' => [
        'alert_threshold' => (int) env('AI_USAGE_ALERT_THRESHOLD', 1000),
    ],
];
