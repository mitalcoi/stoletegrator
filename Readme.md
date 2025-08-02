## Описание
- Работа с продуктами и избранным (API) - модуль Product 
- Репозитории (DB и API-ориентированные) - модуль Ticket
- Абстракция над файловым хранилищем (включая AWS S3) + работа с файлами в контексте продукта - модуль Market
- Модель корзины заказов и операций с заказами - модуль Order
- SQL-запросы и оптимизация структуры БД - файл student-grades-report.md
- Релизный цикс - внесение правок, тестирование и релиз библиотеки - файл dependency-update-process.md

---

## Установка зависимостей + Конфигурация

```bash
docker compose up -d

composer install

php bin/console doctrine:database:create
php bin/console doctrine:migration:migrate -n
php bin/console doctrine:fixtures:load

```

## Тесты
Тесты покрывают:
API /api/products с разными пользователями
Репозитории ProductRepository, TicketRepository
Модуль Order - Order, OrderItem
AWS-адаптер для хранилища

```bash
php bin/phpunit

```

## Static analyze

```bash
vendor/bin/phpstan analyse src 
```

![CI](https://github.com/mitalcoi/stoletegrator/actions/workflows/ci.yml/badge.svg)
