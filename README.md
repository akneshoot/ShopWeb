# ShopWeb
Курсовая работа на тему "Книжный магазин"
# Клиент-Серверная Система
Этот проект представляет клиент-серверную систему, включая взаимодействие между клиентом, API и сервером.

## Архитектура системы

```mermaid
graph LR
    Клиент --> Фронтенд
    Фронтенд --> API
    API --> Сервер
    Сервер --> База данных
    Сервер --> Кэш
    API --> Логи
```
