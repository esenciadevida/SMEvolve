<?php

namespace App\Data\Portfolio\Projects;

class ConceptRetailStore
{
    /**
     * A concept project used to demonstrate the SMEvolve approach.
     * Clearly labelled as a concept, it was not delivered to a real client.
     *
     * @return array<string, mixed>
     */
    public function content(): array
    {
        return [
            'slug' => 'concept-fashion-store',
            'title' => 'Fashion Retail Online Store',
            'status' => 'Concept Project',
            'featured' => true,
            'image' => null,
            'category' => 'E-commerce Development',
            'categorySlug' => 'ecommerce',
            'industry' => 'Retail',
            'projectType' => 'Online Store',
            'services' => ['E-commerce Development'],
            'servicesSlugs' => ['ecommerce-development', 'api-development'],
            'summary' => 'A concept online store for a fashion retailer, focused on easy browsing, a smooth shopping cart, and a secure checkout that converts visitors into customers.',
            'shortDescription' => 'A concept fashion online store focused on browsing, cart, and secure checkout for a smooth customer experience.',
            'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'Payment Gateway APIs'],
            'gallery' => [
                ['label' => 'Storefront', 'type' => 'Brand-led homepage and campaigns', 'image' => null],
                ['label' => 'Product Listing', 'type' => 'Filters, search, and product cards', 'image' => null],
                ['label' => 'Checkout', 'type' => 'Secure, step-by-step checkout flow', 'image' => null],
                ['label' => 'Admin Dashboard', 'type' => 'Products, orders, and stock management', 'image' => null],
            ],
            'challenge' => [
                'heading' => 'Selling Fashion Beyond the Store',
                'description' => 'This concept project represents a common retail challenge: a fashion business selling in-store but with no effective online channel. Customers expect to browse and buy on their phones, and without a strong store the business misses sales outside opening hours.',
                'points' => [
                    'No online channel for customers who shop digitally.',
                    'Manual product and order handling that does not scale.',
                    'A shopping experience that needs to feel on-brand.',
                    'Checkout that must be secure and easy to complete.',
                ],
            ],
            'solution' => [
                'heading' => 'A Store Built Around the Shopping Experience',
                'description' => 'As a concept, this project demonstrates how SMEvolve would approach the build: prioritise the customer journey from product discovery to checkout, then give the retailer simple tools to manage products and orders. The result is a fast, mobile-first store with a secure checkout.',
                'points' => [
                    'Mobile-first design because most shopping happens on phones.',
                    'Search and filters that help customers find products quickly.',
                    'A secure, friction-light checkout process.',
                    'Simple product, order, and stock management.',
                    'A scalable foundation for growth and promotions.',
                ],
            ],
            'features' => [
                ['icon' => 'rectangle-stack', 'title' => 'Product Catalogue', 'description' => 'Manage products, categories, pricing, and images with ease.'],
                ['icon' => 'magnifying-glass', 'title' => 'Search & Filters', 'description' => 'Help customers find what they want quickly.'],
                ['icon' => 'shopping-cart', 'title' => 'Shopping Cart', 'description' => 'A smooth cart experience that keeps customers moving to checkout.'],
                ['icon' => 'shield-check', 'title' => 'Secure Checkout', 'description' => 'A reliable checkout that builds customer confidence.'],
                ['icon' => 'credit-card', 'title' => 'Payment Integration', 'description' => 'Connect the payment gateways customers expect and trust.'],
                ['icon' => 'clipboard-document-list', 'title' => 'Order Management', 'description' => 'Track and fulfil orders from one clear dashboard.'],
                ['icon' => 'user-group', 'title' => 'Customer Accounts', 'description' => 'Let customers save details and track their orders.'],
                ['icon' => 'ticket', 'title' => 'Promotions & Discounts', 'description' => 'Run campaigns that encourage purchases and repeat visits.'],
            ],
            'outcome' => [
                'heading' => 'Designed to Deliver',
                'description' => 'Because this is a concept project, no real business outcomes can be claimed. The store is designed to support qualitative improvements such as a stronger online presence, a smoother customer experience, and simpler order management.',
                'points' => [
                    'A professional online presence that complements the store.',
                    'A smoother shopping experience for customers.',
                    'Simpler product and order management for the team.',
                ],
            ],
            'meta' => [
                'title' => 'Concept Project: Fashion Retail Online Store',
                'description' => 'A concept fashion e-commerce store by SMEvolve, a fast, mobile-first store focused on browsing, cart, and secure checkout.',
            ],
        ];
    }
}
