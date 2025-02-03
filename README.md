# Application Processing System (APS)

## Описание проекта
APS — это система обработки заявок и возможностью управления тикетами для компаний.

## Быстрый старт

### 1. Клонирование репозитория
```bash  
git clone https://github.com/denisparamon/applicationProcessingSystem
```

2. Установка зависимостей
```bash
composer install
```  
3. Создание базы данных  
   Убедитесь, что у вас установлен PostgreSQL, и создайте базу данных, указанную в конфигурации.  
```bash
symfony console doctrine:database:create
```  
4. Запуск миграций
   Выполните миграции для создания таблиц в базе данных:
```bash
symfony console doctrine:migrations:migrate
```  
5. Запуск сервера
   Для запуска веб-сервера используйте команду:
```bash
symfony server:start
```  
6. Конфигурация
   Если необходимо изменить параметры подключения к базе данных, откройте файл .env или .env.local и обновите строку:
```bash
DATABASE_URL="postgresql://app:******@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```  
Замените ****** на ваш собственный пароль для базы данных, если это необходимо.  
7. Создание базы данных
Выполните следующую команду для создания базы:
```bash
php bin/console doctrine:database:create
```  
8. Применение миграций
   Для создания таблиц выполните:
```bash
php bin/console doctrine:migrations:migrate
``` 
9. Проверка базы данных
   Подключитесь через клиент psql:
```bash
psql -U app -d app
``` 

5. Проверка структуры
   Список таблиц:
```bash
\dt
``` 


