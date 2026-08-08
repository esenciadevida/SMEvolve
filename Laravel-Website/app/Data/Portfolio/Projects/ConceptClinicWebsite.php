<?php

namespace App\Data\Portfolio\Projects;

class ConceptClinicWebsite
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
            'slug' => 'concept-clinic-website',
            'title' => 'Healthcare Clinic Website',
            'status' => 'Concept Project',
            'featured' => true,
            'image' => null,
            'category' => 'Website Development',
            'categorySlug' => 'websites',
            'industry' => 'Healthcare',
            'projectType' => 'Business Website',
            'services' => ['Website Development', 'WordPress Development'],
            'servicesSlugs' => ['website-development', 'wordpress-development'],
            'summary' => 'A concept website for a healthcare clinic, designed around patient journeys, clear services, easy appointment enquiries, and an online presence that builds trust.',
            'shortDescription' => 'A concept clinic website designed around patient journeys, with clear services and easy appointment enquiries.',
            'technologies' => ['WordPress', 'PHP', 'MySQL', 'Tailwind CSS', 'JavaScript'],
            'gallery' => [
                ['label' => 'Homepage', 'type' => 'Brand, services overview, and trust signals', 'image' => null],
                ['label' => 'Services Page', 'type' => 'Treatments and services explained clearly', 'image' => null],
                ['label' => 'Appointment Enquiry', 'type' => 'Simple request form with confirmation', 'image' => null],
                ['label' => 'Mobile View', 'type' => 'Responsive experience on phones', 'image' => null],
            ],
            'challenge' => [
                'heading' => 'A Trustworthy Online Presence for Patients',
                'description' => 'This concept project represents a common healthcare challenge: a clinic with little online presence whose patients cannot easily find services, opening hours, or how to book an appointment.',
                'points' => [
                    'Potential patients struggle to find basic information.',
                    'No clear way to request an appointment online.',
                    'An outdated look that fails to build confidence.',
                    'Poor mobile experience for people browsing on phones.',
                ],
            ],
            'solution' => [
                'heading' => 'Designed Around the Patient Journey',
                'description' => 'As a concept, this project demonstrates how SMEvolve would approach the build: structure the site around what patients are trying to do, understand the clinic, see the services, and get in touch. The result is a calm, professional, mobile-friendly website that is easy for the clinic team to update.',
                'points' => [
                    'Information architecture based on real patient questions.',
                    'Clear service and doctor sections that build trust.',
                    'A simple appointment enquiry flow with confirmation.',
                    'Responsive design that works on every device.',
                    'An easy-to-manage CMS so content stays current.',
                ],
            ],
            'features' => [
                ['icon' => 'device-desktop', 'title' => 'Responsive Design', 'description' => 'A layout that adapts cleanly to desktops, tablets, and phones.'],
                ['icon' => 'rectangle-stack', 'title' => 'Content Management', 'description' => 'Update services, team, and news without technical help.'],
                ['icon' => 'calendar', 'title' => 'Appointment Enquiry', 'description' => 'A simple form that sends enquiries straight to the clinic.'],
                ['icon' => 'user-group', 'title' => 'Doctor Profiles', 'description' => 'Introduce the team and build confidence with patients.'],
                ['icon' => 'magnifying-glass', 'title' => 'SEO-Ready Structure', 'description' => 'Clean structure that helps patients find the clinic online.'],
                ['icon' => 'chat-bubble-left-right', 'title' => 'Contact & Directions', 'description' => 'Location, hours, and contact details always easy to find.'],
            ],
            'outcome' => [
                'heading' => 'Designed to Deliver',
                'description' => 'Because this is a concept project, no real business outcomes can be claimed. The site is designed to support qualitative improvements such as a stronger online presence, easier appointment enquiries, and a more professional image.',
                'points' => [
                    'A professional online presence that builds trust.',
                    'Easier for patients to find information and enquire.',
                    'Content the clinic team can update themselves.',
                ],
            ],
            'meta' => [
                'title' => 'Concept Project: Healthcare Clinic Website',
                'description' => 'A concept healthcare clinic website by SMEvolve, a trustworthy, mobile-friendly site designed around patient journeys.',
            ],
        ];
    }
}
