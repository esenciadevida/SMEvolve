<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Portal Permissions
    |--------------------------------------------------------------------------
    |
    | Centralized, documented permission definitions. Every permission used in
    | the application must be declared here with a human-readable label, a
    | description and a risk classification. Roles reference these permission
    | keys; the label is what administrators see in the Admin Portal.
    |
    */

    'dashboard.view' => [
        'label' => 'View Dashboard',
        'description' => 'Access the administrative dashboard.',
        'risk' => 'low',
    ],

    'settings.view' => [
        'label' => 'View Settings',
        'description' => 'View approved website settings.',
        'risk' => 'low',
    ],

    'settings.update' => [
        'label' => 'Update Settings',
        'description' => 'Update approved website settings.',
        'risk' => 'medium',
    ],

    'quotes.view' => [
        'label' => 'View Quotes',
        'description' => 'View quote submissions.',
        'risk' => 'low',
    ],

    'quotes.search' => [
        'label' => 'Search Quotes',
        'description' => 'Search quote submissions.',
        'risk' => 'low',
    ],

    'quotes.update_status' => [
        'label' => 'Update Quote Status',
        'description' => 'Change the operational status of quote submissions.',
        'risk' => 'medium',
    ],

    'portfolio.view' => [
        'label' => 'View Portfolio',
        'description' => 'View portfolio projects and their categories.',
        'risk' => 'low',
    ],

    'portfolio.create' => [
        'label' => 'Create Portfolio',
        'description' => 'Create portfolio projects and categories.',
        'risk' => 'medium',
    ],

    'portfolio.update' => [
        'label' => 'Update Portfolio',
        'description' => 'Update portfolio projects and categories.',
        'risk' => 'medium',
    ],

    'portfolio.publish' => [
        'label' => 'Publish Portfolio',
        'description' => 'Publish or unpublish portfolio projects.',
        'risk' => 'medium',
    ],

    'portfolio.delete' => [
        'label' => 'Delete Portfolio',
        'description' => 'Permanently delete portfolio projects and categories.',
        'risk' => 'high',
    ],

    'chatbot.view' => [
        'label' => 'View Chatbot',
        'description' => 'View chatbot settings.',
        'risk' => 'low',
    ],

    'chatbot.update' => [
        'label' => 'Update Chatbot',
        'description' => 'Update chatbot configuration.',
        'risk' => 'medium',
    ],

    'ai.view' => [
        'label' => 'View AI',
        'description' => 'View safe AI configuration and status.',
        'risk' => 'low',
    ],

    'ai.update' => [
        'label' => 'Update AI',
        'description' => 'Update safe AI configuration values.',
        'risk' => 'high',
    ],

    'administrators.view' => [
        'label' => 'View Administrators',
        'description' => 'View administrator accounts.',
        'risk' => 'high',
    ],

    'administrators.create' => [
        'label' => 'Create Administrators',
        'description' => 'Create administrator accounts.',
        'risk' => 'high',
    ],

    'administrators.update' => [
        'label' => 'Update Administrators',
        'description' => 'Update administrator accounts.',
        'risk' => 'high',
    ],

    'administrators.disable' => [
        'label' => 'Disable Administrators',
        'description' => 'Disable or reactivate administrator accounts.',
        'risk' => 'high',
    ],

    'administrators.change_role' => [
        'label' => 'Change Roles',
        'description' => 'Change an administrator role.',
        'risk' => 'high',
    ],

    'audit.view' => [
        'label' => 'View Audit Log',
        'description' => 'View the administrative audit log.',
        'risk' => 'high',
    ],

    'profile.update' => [
        'label' => 'Update Profile',
        'description' => 'Update the authenticated administrator profile.',
        'risk' => 'low',
    ],

    'security.password_update' => [
        'label' => 'Update Password',
        'description' => 'Change the authenticated administrator password.',
        'risk' => 'low',
    ],
];
