# Sushi Market — Requirements

## Goal
Create a modern online sushi-market for the Russian market. Core flow:
catalog → cart → checkout → delivery/pickup → payment → confirmation → tracking → fulfillment.

## Stack
- PHP
- Laravel
- Livewire
- Blade
- Tailwind CSS
- Vite
- Filament
- MySQL
- YooKassa

Do not introduce React/Vue for the main customer interface. Redis is optional; database queue is acceptable for MVP.

## Customer pages
/, /menu, /menu/{category}, /menu/{category}/{product}, /cart, /checkout,
/track/{token}, /promotions, /delivery, /about, /contacts, /faq,
/login, /register, /account, /account/orders, /account/addresses,
/account/favorites, /account/profile.

Final URL structure must follow the semantic core.

## Homepage
Hero, main order CTA, popular products, sets, promotions, new products, categories,
advantages, delivery, pickup, reviews, FAQ, contacts, SEO content.

## Catalog
Dynamic categories and products. Product data:
name, slug, description, composition, weight, pieces, price, old price,
discount, images, availability, labels (hit/new/promotion), characteristics,
allergens where applicable, modifiers.

Initial possible categories:
Rolls, Sushi, Sets, Sashimi, WOK, Hot dishes, Snacks, Drinks, Sauces and extras.

## Filters
Dynamic attributes must not be ENUM. Use:
attributes, attribute_values, product_attribute_values.
Examples: type, spicy, baked, vegetarian, vegan, size.

## Product page
Photo/gallery, name, composition, weight, pieces, price, discount, characteristics,
modifiers, add-to-cart, related products.

## Modifiers
Soy sauce, wasabi, ginger, chopsticks, extra sauce, extra ingredients.
Modifiers have name, price, availability and product/category associations.

## Cart
Add/remove/change quantity, modifiers, promo code, discounts, delivery calculation,
final total. All money calculations are server-side.

## Checkout
Name, phone, email, city, street, house, apartment, floor, intercom, comment.
Delivery or pickup. As soon as possible or scheduled time.

## Delivery
One city is sufficient. Delivery zones are configurable in admin and may define
price, free-delivery threshold, minimum order, availability and estimated time.
Do not hard-code actual city/zone/tariff values until supplied.

## Pickup
Support one or more pickup locations; if there is one, keep the UI simple.

## Promotions
Promo codes: fixed/percentage discount, minimum order, dates, usage limits,
per-customer limits, product/category restrictions, enable/disable.

## Orders
Internal statuses:
pending, waiting_payment, paid, confirmed, cooking, ready, delivering,
completed, cancelled, refunded.

Status transitions must be controlled by business logic.

## Order tracking
Required. Customer-facing statuses:
Order placed, Payment received, Accepted by restaurant, Preparing, Ready,
Courier is on the way, Delivered.

Store order_status_history with status, timestamp, optional comment and actor.

Guest tracking uses a secure unique token at /track/{token}. Never expose an order
merely by sequential order number and do not expose unnecessary personal data.

## Notifications
Prepare architecture for SMS, email, VK, Telegram and future channels.
Events: created, paid, accepted, cooking, ready, handed to courier, delivered, cancelled.

## Payments
YooKassa. Flow:
create order → create payment → customer pays → webhook → verify payment status →
mark order paid.

Never treat a browser redirect as proof of payment. Support external payment ID,
webhooks, status verification, errors, cancellation, refunds and idempotency.

## Fiscalization
Architecture must preserve order-item data needed for fiscal receipts.
Actual 54-FZ/cash-register configuration must be aligned with the restaurant's real setup.

## Authentication
Guest checkout is required.
Support VK ID, phone and email. One customer profile can have multiple login methods.
Use users + social_accounts rather than duplicate users per provider.

## Customer account
Profile, order history, saved addresses, favorites, repeat order.
If a previous product is unavailable during repeat order, show a warning and allow continuation.

## Admin
Use Filament. Sections:
Dashboard, Orders, Products, Categories, Attributes, Modifiers, Customers, Addresses,
Promo codes, Promotions, Delivery zones, Pickup locations, Reviews, Content, SEO,
Settings, Users, Roles.

## Kitchen
If needed, use a dedicated Livewire kitchen interface rather than forcing the workflow into generic CRUD.

## Roles
Super Admin, Admin, Manager, Operator, Kitchen.

## SEO
Build from the beginning:
clean URLs, title, description, canonical, robots, Open Graph, sitemap.xml,
robots.txt, breadcrumbs, Schema.org (Restaurant/FoodEstablishment, Product,
BreadcrumbList, FAQPage where appropriate).

Semantic core must be collected and clustered before final URL structure.
Do not create keyword-only pages.

## Database
Initial entities:
users, social_accounts, categories, products, product_images,
attributes, attribute_values, product_attribute_values, modifiers,
product_modifiers, orders, order_items, order_status_history, customers, addresses,
payments, payment_events, refunds, promocodes, promocode_usages, delivery_zones,
pickup_locations, favorites, reviews, pages, seo_meta, restaurant_settings, opening_hours.

ENUM only for genuinely fixed system states. Dynamic business data stays relational.

## Services
CartService, OrderService, DeliveryService, PaymentService, PromotionService,
CustomerService, NotificationService.

Payment abstraction:
PaymentService → YooKassaProvider, leaving room for another provider later.

## Livewire
Use for catalog, filters, product interactions, cart, modifiers, promo codes,
checkout, delivery selection, time selection, tracking, account and kitchen UI.
Avoid giant components; each component has one clear responsibility.

## Security
Server-side validation, policies/gates, CSRF, rate limiting, webhook protection,
secure tracking tokens, server-side price verification, idempotent payment handling,
secure secrets and critical-action logging.

## Testing
Cover cart totals, promo codes, delivery, order creation, payment creation,
webhooks/retries, successful/failed payments, status changes, guest tracking,
authentication, repeat orders and admin permissions.

## Development stages
1. Foundation
2. Catalog
3. Cart
4. Checkout
5. Orders
6. YooKassa
7. Tracking
8. Authentication/account
9. SEO
10. Testing/production

## Codex rules
Read docs/REQUIREMENTS.md, docs/BUSINESS.md and docs/DEVELOPMENT.md before major changes.
Inspect existing code before editing. Work in stages. Do not silently make major
architectural decisions. Run tests/build checks after each stage. Do not move to
the next stage automatically. Do not invent business data.

## MVP exclusions
No mobile app, microservices, complex CRM, advanced loyalty system, unnecessary
integrations, React/Vue frontend or Redis without a real requirement.
