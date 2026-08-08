# SMEvolve

SMEvolve is a technology company that helps businesses grow by delivering modern digital solutions. This repository contains the SMEvolve corporate website — the company's primary digital platform for attracting clients, showcasing expertise, and generating qualified leads.

**Website:** https://smevolve.tech

## About the Project

The SMEvolve website communicates professionalism, technical expertise, and trust while providing a seamless, responsive user experience. It includes:

- Homepage
- About
- Services (with individual service pages)
- Packages
- Portfolio
- FAQ
- Contact
- Project Quote Wizard
- AI-powered assistant and quote flow
- Admin Portal for content management
- Privacy Policy and Terms & Conditions

## Technology Stack

| Layer | Technology |
|--------|------------|
| Backend | Laravel 12 |
| Frontend | Blade templates |
| Styling | Tailwind CSS v4 |
| JavaScript | Alpine.js + Vanilla JavaScript |
| Database | MySQL 8+ |
| Package Managers | Composer, npm |
| Asset Builder | Vite |
| Version Control | Git + GitHub |
| Production Hosting | Hostinger |
| Fonts | Inter |

## Repository Structure

```text
SMEvolve/
├── Laravel-Website/       # Laravel 12 application
├── Documentation/         # Project documentation (specification)
├── AI_Instructions/       # Controlled development process instructions
├── Assets/                # Brand assets
└── AGENTS.md              # AI agent instructions
```

## Requirements

- PHP 8.3+
- Composer
- Node.js LTS + npm
- MySQL 8+
- Git

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/esenciadevida/SMEvolve.git
   cd SMEvolve/Laravel-Website
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install frontend dependencies:

   ```bash
   npm install
   ```

4. Copy and configure the environment file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

## Environment Configuration

The repository ships with `.env.example` only — never commit `.env`. Required variables include database credentials, mail settings, and AI provider keys. Configure `.env` to match your local or production environment.

## Database Setup

1. Create an empty MySQL database.
2. Set `DB_*` values in `.env`.
3. Run migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

## Testing

Run the automated test suite:

```bash
php artisan test
```

## Development Commands

```bash
# Build frontend assets
npm run dev        # watch mode
npm run build      # production build

# Laravel tooling
php artisan serve  # local dev server
php artisan migrate --seed
```

## Deployment Overview

The deployment architecture is:

```text
GitHub (source control)
    ↓
CI (automated checks)
    ↓
Hostinger (production hosting)
```

Production is deployed from the `main` branch after CI passes. See `Documentation/18_Deployment/` for the full deployment workflow, environment configuration, and production checklist.

## Documentation

The complete specification lives in `Documentation/` and is the authoritative reference for the project. Key areas include the PRD (`Documentation/01_PRD/`), design system, per-module implementation docs, and deployment docs. The `AI_Instructions/` folder documents the controlled development process.

## License

Proprietary — all rights reserved. Do not distribute without permission.
