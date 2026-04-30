# Discover Kyrgyzstan - Premium Tourism Platform

## 🏔️ О Проекте

Премиальная туристическая платформа для Кыргызстана, разработанная с целью победы на международных конкурсах веб-дизайна (Awwwards, CSS Design Awards, Webby Awards).

Сайт сочетает в себе современные технологии, аутентичную кыргызскую культуру и впечатляющий дизайн, создавая эмоциональное погружение в мир кочевников.

---

## 🚀 Технологии

### Backend
- **PHP 8.2+** - Современный PHP со строгой типизацией
- **PDO с Prepared Statements** - Полная защита от SQL-инъекций
- **MVC Архитектура** - Чистое разделение логики
- **MySQL 8.0+ / MariaDB 10.6+** - Надёжная база данных

### Frontend
- **Tailwind CSS 3.x** - Утилитарный CSS фреймворк
- **Alpine.js** - Лёгкий JavaScript фреймворк для интерактивности
- **AOS (Animate On Scroll)** - Плавные анимации при прокрутке
- **Google Fonts** - Playfair Display + Inter

### Дизайн-система
- **Цветовая палитра**: Глубокие горные оттенки (kg-blue, kg-emerald, kg-gold, kg-terracotta)
- **Типографика**: Элегантные шрифты с отличной читаемостью
- **Эффекты**: Glassmorphism, Parallax, Hover-анимации
- **Культурные элементы**: Орнамент "ала-кийиз" в дизайне

---

## 📁 Структура Проекта

```
/workspace/
├── public/                     # Публичная директория
│   ├── index.php              # Точка входа (Front Controller)
│   ├── assets/                # Статические ресурсы
│   │   ├── css/               # Стили
│   │   ├── js/                # Скрипты
│   │   ├── images/            # Изображения
│   │   ├── fonts/             # Шрифты
│   │   └── videos/            # Видео
│   └── uploads/               # Загруженные файлы
│       ├── tours/             # Фото туров
│       ├── regions/           # Фото регионов
│       ├── attractions/       # Фото достопримечательностей
│       ├── audio/             # Аудиогиды
│       ├── avatars/           # Аватары пользователей
│       └── blog/              # Фото блога
├── src/                       # Исходный код приложения
│   ├── Config/                # Конфигурация
│   │   ├── config.php         # Основные настройки
│   │   └── Database.php       # Подключение к БД
│   ├── Controllers/           # Контроллеры
│   │   ├── Controller.php     # Базовый контроллер
│   │   ├── HomeController.php
│   │   ├── TourController.php
│   │   └── ...
│   ├── Models/                # Модели
│   │   ├── Model.php          # Базовая модель
│   │   ├── Tour.php
│   │   ├── Region.php
│   │   ├── Attraction.php
│   │   ├── Booking.php
│   │   └── ...
│   ├── Middleware/            # Промежуточное ПО
│   └── Helpers/               # Вспомогательные функции
│       └── functions.php
├── templates/                 # Шаблоны представлений
│   ├── layouts/               # Макеты
│   │   └── main.php           # Основной макет
│   ├── partials/              # Части шаблонов
│   │   ├── navigation.php
│   │   └── footer.php
│   ├── pages/                 # Страницы
│   │   ├── home/
│   │   ├── tours/
│   │   ├── errors/
│   │   └── ...
│   └── admin/                 # Админ-панель
├── storage/                   # Хранилище
│   ├── logs/                  # Логи
│   ├── cache/                 # Кэш
│   └── sessions/              # Сессии
└── database.sql               # Дамп базы данных
```

---

## 🗄️ База Данных

### Таблицы

| Таблица | Описание |
|---------|----------|
| `users` | Пользователи (туристы, админы, менеджеры) |
| `regions` | 7 областей Кыргызстана |
| `attractions` | Достопримечательности и места |
| `tours` | Туры и пакеты услуг |
| `tour_regions` | Связь туров с регионами (M:M) |
| `tour_images` | Галерея изображений туров |
| `bookings` | Бронирования туров |
| `audio_guides` | Аудиогиды (RU/EN/KG) |
| `reviews` | Отзывы туристов |
| `favorites` | Избранные туры |
| `blog_posts` | Статьи и истории |
| `settings` | Настройки сайта |
| `sliders` | Слайдеры главной страницы |

### Установка БД

```bash
mysql -u root -p < database.sql
```

---

## 🔧 Установка и Настройка

### 1. Требования к серверу
- PHP 8.2+ с расширениями: pdo, pdo_mysql, mbstring, json, openssl
- MySQL 8.0+ или MariaDB 10.6+
- Веб-сервер: Apache с mod_rewrite или Nginx
- HTTPS (рекомендуется для production)

### 2. Клонирование и настройка

```bash
# Перейдите в директорию проекта
cd /workspace

# Импортируйте базу данных
mysql -u username -p kg_tourism_db < database.sql

# Настройте права доступа
chmod -R 755 public/uploads
chmod -R 755 storage
```

### 3. Конфигурация окружения

Создайте файл `.env` (или настройте переменные окружения):

```env
APP_URL=https://yourdomain.com
APP_DEBUG=true

DB_HOST=localhost
DB_PORT=3306
DB_NAME=kg_tourism_db
DB_USER=username
DB_PASS=password

MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### 4. Настройка веб-сервера

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
```

#### Nginx
```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    
    root /workspace/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 🎨 Дизайн-концепция

### Цветовая палитра

```
kg-blue      #0d8eed → #0070d3    (Иссык-Куль, небо)
kg-emerald   #20b988 → #10996e    (Горные луга, леса)
kg-gold      #f59e0b → #d97706    (Солнце, пшеница)
kg-terracotta #e05d43 → #b02d1f   (Глина, традиционная посуда)
kg-sand      #f5f0eb              (Песок, юрты)
kg-dark      #1a1f2e              (Ночь в горах)
```

### Типографика

- **Заголовки**: Playfair Display (элегантный serif)
- **Текст**: Inter (чистый sans-serif)

### Культурные элементы

- Орнамент "ала-кийиз" в фонах и разделителях
- Стилизованные иконки юрт и гор
- Органические формы, напоминающие горные хребты

---

## ✨ Ключевые Функции

### Для пользователей
- ✅ Immersive Hero-секция с видео
- ✅ Поиск и фильтрация туров
- ✅ Интерактивная карта достопримечательностей
- ✅ Система бронирования с калькулятором
- ✅ Многоязычность (RU/EN/KG)
- ✅ Аудиогид с загрузкой через админку
- ✅ Избранное с сохранением в БД
- ✅ Отзывы с фотографиями

### Админ-панель
- ✅ CRUD для всех сущностей
- ✅ Dashboard со статистикой
- ✅ Управление бронированиями
- ✅ Загрузка и оптимизация медиа
- ✅ Управление пользователями

---

## 🔒 Безопасность

- **SQL-инъекции**: Prepared statements (PDO)
- **XSS**: htmlspecialchars() для всего вывода
- **CSRF**: Токены для всех форм
- **Rate Limiting**: Ограничение запросов
- **Session Security**: HttpOnly, Strict Mode
- **Password Hashing**: password_hash() (bcrypt)

---

## 📈 SEO Оптимизация

- Чистые URL (slug-based)
- Meta-теги (title, description, keywords)
- Open Graph для соцсетей
- Schema.org разметка для туров
- Sitemap.xml
- Robots.txt
- Lazy loading изображений

---

## 🚀 Roadmap

### Phase 1 (Completed)
- [x] Архитектура проекта
- [x] База данных
- [x] MVC каркас
- [x] Главная страница
- [x] Навигация и футер

### Phase 2 (In Progress)
- [ ] Страница туров (listing)
- [ ] Детальная страница тура
- [ ] Система бронирования
- [ ] Админ-панель (базовая)

### Phase 3 (Planned)
- [ ] Интерактивная карта
- [ ] Аудиогид плеер
- [ ] Блог система
- [ ] Платежная интеграция
- [ ] Email уведомления

---

## 📝 Лицензия

© 2024 Discover Kyrgyzstan. Все права защищены.

---

## 👥 Команда

Разработано с ❤️ для продвижения туризма в Кыргызстане.
