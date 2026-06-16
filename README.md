# MOBUX

Laravel 10 project with an admin module `Company Parser` for collecting companies by city and category.

## Company Parser

### Как запустить миграции

```bash
php artisan migrate
```

Новые миграции для Overpass provider не нужны. Если модуль уже был установлен ранее, достаточно текущих миграций парсера компаний.

### Как открыть модуль в админке

После входа в админ-панель откройте раздел `Парсер компаний` в боковом меню или перейдите на:

```text
/admin/company-parser
```

### Как запустить mock-парсер

Из админки:

1. Откройте `Парсер компаний`.
2. Укажите город и категорию.
3. В поле источника выберите `mock`.
4. Нажмите `Запустить парсер`.

Из CLI:

```bash
php artisan companies:parse "Москва" "Кофейни" --provider=mock --limit=20 --sync
```

### OpenStreetMap / Overpass API

Пример запуска:

```bash
php artisan companies:parse "Москва" "Кофейни" --provider=overpass --limit=50 --sync
```

Пример через админку:

- Источник: `overpass`
- Город: `Москва`
- Категория: `Кофейни`

Ограничения:

- Overpass API бесплатный, но не предназначен для агрессивного массового парсинга.
- Нужно использовать небольшие лимиты.
- Данные OSM могут быть неполными.
- Рейтингов и отзывов в OSM обычно нет.
- Сайт может быть указан в `website` или `contact:website`.
- Если на локальном Windows-окружении есть SSL-проблема с сертификатами, для dev-режима можно временно указать `COMPANY_PARSER_OVERPASS_VERIFY=false`.

### Как настроить queue worker

Укажите в `.env`:

```dotenv
QUEUE_CONNECTION=database
COMPANY_PARSER_QUEUE=company-parser
COMPANY_PARSER_PROVIDER=overpass
COMPANY_PARSER_LIMIT=50
```

Затем запустите worker:

```bash
php artisan queue:work --queue=company-parser,default
```

### Как подключить реальный provider

1. Создайте класс, который реализует `App\Services\CompanyParser\Contracts\CompanyParserProviderInterface`.
2. Вынесите всю интеграцию с внешним API внутрь provider-класса.
3. Зарегистрируйте provider в `config/company_parser.php`.
4. При необходимости смените `COMPANY_PARSER_PROVIDER` в `.env`.

Контроллеры менять не нужно: модуль использует реестр провайдеров и сервисный слой.

## CLI команды

Универсальная команда:

```bash
php artisan companies:parse {city} {category} {--provider=overpass} {--limit=50} {--sync}
```

Примеры:

```bash
php artisan companies:parse "Москва" "Кофейни" --provider=overpass --limit=50 --sync
php artisan companies:parse "Москва" "Кофейни" --provider=mock --limit=20 --sync
```
