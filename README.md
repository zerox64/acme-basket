# Acme Basket

A modular PHP basket system implementing discount strategies and delivery rules.

## Requirements

- PHP 8.2
- Composer
- Docker

## Instructions

### 1. Clone the repository

```bash
git clone https://github.com/zerox64/acme-basket.git
cd acme-basket
```

### 2. Install dependencies

```bash
composer install
```

### 3. Run Tests

```bash
vendor/bin/phpunit
```
or
```bash
composer test
```

### 4. Run Analysis

```bash
vendor/bin/phpstan analyse
```
or
```bash
compose analyze
```

### 5. Run Example

```bash
php example.php
```

## Docker

### Build and run container

```bash
docker build -t acme-basket .
docker run --rm acme-basket
```

## Project Structure

- `src/` – Source code (Basket, Offer, Delivery)
- `tests/` – PHPUnit tests
- `example.php` – Demonstrates how to initialize a basket, add products, and calculate the final total including discounts and delivery.
