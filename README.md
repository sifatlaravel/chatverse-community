# Chatverse Community Edition — Laravel AI MicroSaaS

A production-oriented AI SaaS architecture showcase built with Laravel 12.

Chatverse demonstrates scalable SaaS engineering patterns including:
- AI chatbot infrastructure
- embeddable widgets
- multi-bot management
- subscription-ready architecture
- modular Laravel service design
- lead capture workflows
- AI conversation systems

---

## Purpose

Chatverse Community Edition exists primarily for:

- SaaS architecture showcase
- educational purposes
- portfolio demonstration
- learning modern Laravel AI SaaS patterns
- reference implementation for scalable AI products

This repository is not intended to be used as a turnkey commercial clone.

---

## Features

### Marketing Website
- Home page
- Features page
- Pricing page
- Demo page
- Documentation pages

### Authentication
- Register/Login
- Forgot/Reset password
- Email verification
- Protected dashboard routes

### Billing System (v1)
- Manual invoices
- Bank transfer support
- bKash payment support
- Admin approval workflow

### Bot Management
- Multi-bot support
- Knowledge base configuration
- Theme customization
- Optional domain allowlist

### AI Infrastructure
- OpenAI Chat Completions integration
- Conversation persistence
- AI message orchestration
- Context-aware responses

### Widget System
- Lightweight embeddable widget
- Fast-loading UI
- Lead capture support
- External website integration

### Admin Panel
- Invoice approval system
- User moderation
- Basic SaaS administration workflow

---

## Tech Stack

- PHP 8.2
- Laravel 12
- Blade
- TailwindCSS
- Vite
- MySQL
- OpenAI API

---

## Quick Start

From the project root:

```bash
composer install

cp .env.example .env

php artisan key:generate

# Configure database in .env

php artisan migrate --seed

php artisan storage:link

npm install

npm run dev

php artisan serve
```

---

## OpenAI Setup

Inside `.env`:

```env
OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4o-mini
```

If no API key is configured, the widget will return a fallback configuration message.

---

## Admin Login

Seeder creates a default admin account:

```txt
Email: admin@chatverse.test
Password: password
```

Admin dashboard:

```txt
/admin
```

---

## Widget Embed

Each bot includes a public widget key.

Example embed:

```html
<link rel="stylesheet" href="https://YOUR_DOMAIN/chatverse/widget/chatverse-widget.css">

<script
    src="https://YOUR_DOMAIN/chatverse/widget/chatverse-widget.js"
    data-bot="PUBLIC_KEY_HERE"
    defer>
</script>
```

---

## Project Structure Highlights

```txt
app/
├── Http/
├── Models/
├── Services/
├── Middleware/
├── Providers/

resources/
├── views/

routes/
├── web.php
├── api.php
```

Architecture goals:
- modularity
- service-oriented structure
- SaaS scalability
- AI extensibility
- production readiness

---

## Buddy Visual Assets

Buddy assets are located inside:

```txt
public/assets/buddy/
```

Optimized WebP assets are included for:
- lightweight loading
- responsive UI rendering
- modern browser performance

---

## Notes

- Billing is intentionally manual in v1 for rapid deployment simplicity
- Stripe/Paddle integration can be added later
- Queue workers and realtime systems can be extended further
- This repository focuses on architecture and SaaS foundation patterns

---

## License & Usage

You may:
- study the code
- learn from the architecture
- modify components
- use concepts in your own projects
- use the repository as a starter reference

You may not:
- redistribute Chatverse branding/assets
- deploy near-identical commercial clones
- use Chatverse identity without permission
- resell the project as an unchanged SaaS product

See:
- LICENSE
- TRADEMARK.md
- COMMERCIAL_USE.md

---

## Disclaimer

This repository represents a community/showcase edition of Chatverse.

Certain production systems, internal tooling, advanced orchestration logic, and commercial infrastructure may remain private.

---

## Future Expansion Ideas

- Stripe/Paddle billing
- Vector search
- Streaming AI responses
- Realtime messaging
- Multi-agent systems
- CRM integrations
- Team collaboration
- Analytics dashboard
- AI workflow automation

---

## Author

Built by Sifat Haque

Portfolio:
https://sifatlaravel.com