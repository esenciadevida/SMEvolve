<?php

namespace App\Data\Portfolio\Projects;

class SampleInventorySystem
{
    /**
     * A sample project used to demonstrate the SMEvolve approach.
     * Clearly labelled as a sample, it was not delivered to a real client.
     *
     * @return array<string, mixed>
     */
    public function content(): array
    {
        return [
            'slug' => 'sample-inventory-system',
            'title' => 'Inventory Management System',
            'status' => 'Sample Project',
            'featured' => true,
            'image' => null,
            'category' => 'Custom Software',
            'categorySlug' => 'custom-software',
            'industry' => 'Retail & Distribution',
            'projectType' => 'Web Application',
            'services' => ['Custom Software Development'],
            'servicesSlugs' => ['custom-software'],
            'summary' => 'A sample inventory management concept showing how a growing business could track stock, orders, and suppliers in one clear system instead of juggling spreadsheets.',
            'shortDescription' => 'A sample inventory system concept demonstrating how a business could track stock, orders, and suppliers in one clear platform.',
            'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'REST APIs'],
            'gallery' => [
                ['label' => 'Dashboard', 'type' => 'Overview of stock levels and activity', 'image' => null],
                ['label' => 'Product Catalogue', 'type' => 'Products, categories, and pricing', 'image' => null],
                ['label' => 'Stock Alerts', 'type' => 'Low stock and reorder notifications', 'image' => null],
                ['label' => 'Reports', 'type' => 'Sales, movement, and valuation reports', 'image' => null],
            ],
            'challenge' => [
                'heading' => 'Tracking Stock Across Spreadsheets',
                'description' => 'This sample project represents a common challenge: a business relying on spreadsheets and separate tools to manage inventory. Stock counts drift out of date, orders and suppliers live in different places, and reporting takes manual effort.',
                'points' => [
                    'Manual stock counts that are slow and error-prone.',
                    'No single view of products, orders, and suppliers.',
                    'Little visibility into what is selling and what is not.',
                    'Limited reporting to support purchasing decisions.',
                ],
            ],
            'solution' => [
                'heading' => 'One Clear System for Inventory',
                'description' => 'As a sample concept, this project demonstrates how SMEvolve would approach the build: understand the workflow first, then design a system that fits how the business actually operates. The platform centralises products, stock levels, orders, and suppliers behind a simple interface.',
                'points' => [
                    'Discovery and workflow analysis before any development.',
                    'A clean dashboard showing stock position at a glance.',
                    'Low stock alerts that trigger reorder reminders.',
                    'Reporting designed around the metrics the business cares about.',
                    'A scalable foundation that can grow with the business.',
                ],
            ],
            'features' => [
                ['icon' => 'rectangle-stack', 'title' => 'Product Catalogue', 'description' => 'Manage products, categories, variants, and pricing in one place.'],
                ['icon' => 'database', 'title' => 'Stock Tracking', 'description' => 'Keep accurate stock levels with movement history for every item.'],
                ['icon' => 'bell', 'title' => 'Low Stock Alerts', 'description' => 'Get notified before items run out so reordering stays ahead of demand.'],
                ['icon' => 'clipboard-document-list', 'title' => 'Order Management', 'description' => 'Record purchase orders and supplier deliveries against stock.'],
                ['icon' => 'user-group', 'title' => 'Role-Based Access', 'description' => 'Control who can view, edit, and approve inventory data.'],
                ['icon' => 'chart-bar', 'title' => 'Reporting', 'description' => 'Understand sales, movement, and stock value with clear reports.'],
            ],
            'outcome' => [
                'heading' => 'Designed to Deliver',
                'description' => 'Because this is a sample project, no real business outcomes can be claimed. The system is designed to support qualitative improvements such as easier stock control, fewer manual errors, and clearer reporting, the results any inventory-focused project would aim for.',
                'points' => [
                    'Easier stock control with fewer manual errors.',
                    'Less time spent reconciling spreadsheets.',
                    'Clearer visibility for purchasing decisions.',
                ],
            ],
            'meta' => [
                'title' => 'Sample Project: Inventory Management System',
                'description' => 'A sample inventory management system concept by SMEvolve, stock, orders, and supplier tracking in one clear, custom-built platform.',
            ],
        ];
    }
}
