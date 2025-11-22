# Car Booking System - API

Laravel API для системы бронирования служебных автомобилей.

## Описание

Система позволяет сотрудникам выбирать доступные служебные автомобили на запланированное время. Каждая должность имеет доступ только к определенным категориям комфорта автомобилей.

---

## Установка

### 1. Клонировать и установить зависимости
```bash
git clone [<repository-url>](https://github.com/Moraa7208/onlycompany.git)
cd car-booking-system
composer install
```

### 2. Настроить окружение
```bash
cp .env.example .env
php artisan key:generate
```

Отредактируйте `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_booking
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Установить Sanctum и запустить миграции
```bash
php artisan install:api
php artisan migrate:fresh --seed
```

Seeders создают: 6 должностей, 3 категории комфорта, 10 водителей, 9 автомобилей, 12 пользователей, 30 бронирований.

Тестовый пользователь: `test@example.com` / `password` (Manager)

### 4. Запустить сервер
```bash
php artisan serve
```

---

## API

### Endpoint: GET /api/available-cars

Получить список доступных автомобилей.

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Query Parameters:**
- `start_time` (required) - Время начала (Y-m-d H:i:s)
- `end_time` (required) - Время окончания (Y-m-d H:i:s)
- `model` (optional) - Фильтр по модели
- `comfort_category_id` (optional) - Фильтр по категории комфорта

**Пример:**
```
GET http://localhost:8000/api/available-cars?start_time=2025-12-25 10:00:00&end_time=2025-12-25 14:00:00&model=Toyota
```

**Ответ:**
```json
{
    "message": "Available cars retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Toyota Camry",
            "model": "Camry",
            "comfort_category": {
                "id": 2,
                "name": "Вторая"
            },
            "driver": {
                "id": 5,
                "name": "Иван Петров"
            }
        }
    ],
    "total": 1
}
```

---

## Получение токена

```bash
php artisan tinker
```

```php
$user = User::first();
echo $user->createToken('test')->plainTextToken;
```

---

## Полезные команды

```bash
# Пересоздать БД с данными
php artisan migrate:fresh --seed

# Проверить маршруты
php artisan route:list --path=api

# Очистить кэш
php artisan config:clear && php artisan cache:clear
```

---

## Структура БД

- users - Пользователи
- positions - Должности
- comfort_categories - Категории комфорта
- drivers - Водители
- cars - Автомобили
- bookings - Бронирования
- position_comfort_category - Связь должностей и категорий

### Правила доступа:
- CEO: Первая, Вторая, Третья
- Director: Первая, Вторая
- Manager: Вторая, Третья
- Senior Specialist: Вторая, Третья
- Specialist: Третья
- Junior Specialist: Третья

---

## Технологии

- Laravel 11.x
- PHP 8.2+
- MySQL
- Laravel Sanctum
