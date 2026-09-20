# Sushi Market — Development Decisions

## Current decisions
- Market: Russia.
- Location scope: one city.
- Customer frontend: Laravel + Blade + Livewire + Tailwind + Vite.
- Admin: Filament.
- Database: MySQL.
- Payments: YooKassa.
- Guest checkout: required.
- Authentication: VK ID, phone, email.
- Order tracking: required.
- Order status history: required.
- Initial queue: database queue is acceptable.
- Redis: optional, only when justified.
- No React/Vue for the main frontend.
- No microservices for MVP.

## Architecture
Use a conventional Laravel monolith.
Business logic belongs in services, not UI templates.

Core services:
CartService
OrderService
DeliveryService
PaymentService
PromotionService
CustomerService
NotificationService

## Payment isolation
Use PaymentService with a provider implementation for YooKassa.
Do not scatter YooKassa-specific calls throughout the application.

## Data rules
Use relational tables for dynamic business data.
ENUM only for fixed system states.

Never trust client-provided:
- price
- totals
- discount amount
- delivery price

Recalculate everything server-side from current database state.

## Order/payment separation
Order status and payment status are separate lifecycles.
A payment redirect is not proof of successful payment.
Webhooks must be safe to retry.

## Tracking security
Guest tracking must use a strong random token.
Do not expose private customer information publicly.

## Authentication linking
A customer may have phone, email and VK linked to one account.
Avoid duplicate customer accounts.

## Vite
Use Laravel's standard Vite integration for CSS/JS assets.
Keep the frontend build simple.

## Codex workflow
Before major work:
1. Read all three docs files.
2. Inspect the repository.
3. State the plan for substantial changes.
4. Implement one stage only.
5. Run tests and relevant build commands.
6. Fix errors.
7. Summarize changes.
8. Stop before unrelated work.

## Do not invent
Do not invent the restaurant name, address, city name, delivery tariffs,
minimum order, menu, prices, hours, branding, cash-register configuration,
SMS provider, VK credentials or other business facts.

Use placeholders until supplied.

## Architectural rule
Prefer the simplest maintainable solution that satisfies current requirements.
Do not add abstraction or infrastructure without a concrete reason.
Security, payment integrity, authorization and customer-data protection are exceptions:
these must be designed correctly from the beginning.
