# Книжный магазин

## Mindmap

```mermaid
mindmap
  root((Книжный магазин))
    Клиентская_часть
      Веб-сайт
        HTML/CSS
        JavaScript
        Vue.js
      Пользовательский_интерфейс
        Регистрация_и_вход
        Просмотр_каталога_книг
        Поиск_и_фильтрация
        Корзина_и_оформление_заказа
    Серверная_часть
      Бэкенд
        Python
        Django
      Базы_данных
        Реляционные_БД
          PostgreSQL
        NoSQL
          Firebase
      API
        REST
        GraphQL
    Безопасность
      Шифрование_персональных_данных
      Защита_от_SQL-инъекций
      Двухфакторная_аутентификация
    Логистика_и_склад
      Управление_остатками
      Отслеживание_доставок
        API_логистических_сервисов
          FedEx
          UPS
    Платежные_системы
      Поддержка_платежей
        Visa
        MasterCard
        PayPal
    Маркетинг_и_аналитика
      Рекомендательные_системы
      Анализ_продаж
        Google_Analytics
      Рассылки
        Электронная_почта
        SMS


# Общий путь пользователя в интернет-магазине игр

## Journey Diagram

```mermaid
journey
    title Общий путь пользователя в интернет-магазине игр
    section Регистрация и вход
      Регистрация нового пользователя: 5: Клиент
      Авторизация пользователя: 5: Клиент
      Проверка данных пользователя: 4: Система
    section Использование системы
      Запрос данных (каталог игр): 5: Клиент
      Обработка запроса: 4: Сервер
      Отображение данных: 5: Клиент
    section Оформление заказа
      Добавление игры в корзину: 5: Клиент
      Проверка наличия игры: 4: Система
      Проверка прав доступа (оплата): 4: Система
      Выполнение оплаты: 5: Клиент
    section Завершение сеанса
      Сохранение заказа: 4: Система
      Завершение сеанса: 5: Клиент
      Выход из системы: 5: Клиент

