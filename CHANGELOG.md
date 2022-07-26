# Changelog
Описание

API по спецификации [JSON API(v1.0)](https://jsonapi.org/format/)

## [Unreleased]
### Added:
- Описание ошибок при выполнении методов; 

## [1.35.0] - 2022.04.07
### Added:
- Партнёр: create, update, view - Товар

## [1.34.0] - 2022.04.07
### Added:
- Партнёр: create, update, view Категория 

## [1.33.0] - 2022.04.06
### Added:
- Create, update, view атрибут партнера

## [1.32.1] - 2022.04.06
### Changed:
- Customer\ProductPolicy, Customer\PartnerPolicy

## [1.32.0] - 2022.04.06
### Added:
- Категории (каталог) товаров. Список(относительно партнёра);
- Товары. Список (относительно партнёра и категории), просмотр с атрибутами;

## [1.31.0] - 2022.04.05
### Added:
- Товар (создание, редактирование) 
- Атрибуты товаров со значениями 

## [1.30.0] - 2022.04.04
### Added:
- Бренд
- Производиетль
- Страна производитель

## [1.29.1] - 2022.04.01
### Added:
- Сохранение атрибутов

## [1.29.0] - 2022.04.01
### Added:
- CRUD категории
- relationship route для атрибут значении

## [1.28.1] - 2022.03.31
### Fixed:
- исправлена проблема "Class "App\JsonApi\Partner\V1\Companies\PartnerSchema" not found";

## [1.28.0] - 2022.03.31
### Added:
- добавлен метод GET /customer/v1/partners;
- добавлен метод GET /customer/v1/partners/{partner_id};

## [1.27.0] - 2022.03.31
### Added:
- добавлен метод GET /customer/v1/employees для получения информации о компаниях по авторизованному пользователю;
- добавлен метод POST /customer/v1/employees;
- добавлен метод GET /customer/v1/employees/{company_user_id};
- добавлен метод PATCH /customer/v1/employees/{company_user_id};
- добавлен метод DELETE /customer/v1/employees/{company_user_id};

### Removed:
- удален GET /customer/v1/company-users;
- удален POST /customer/v1/company-users;
- удален GET /customer/v1/company-users/{company_user_id};
- удален PATCH /customer/v1/company-users/{company_user_id};

## [1.26.0] - 2022.03.31
### Added:
- добавлен метод GET /customer/v1/my-companies для получения информации о компаниях по авторизованному пользователю;
- добавлен метод POST /customer/v1/my-companies;
- добавлен метод GET /customer/v1/my-companies/{company_id};
- добавлен метод PATCH /customer/v1/my-companies/{company_id};

## [1.25.0] - 2022.03.31
### Added:
- добавлены атрибуты для /admin/v1/partner-users;
- добавлены атрибуты для /partner/v1/employees;

## [1.24.1] - 2022.03.30
Added:
- Метод для получение значении атрибутов
- Исправлены заметки: http://gitlab.bytwin.ru/petrushka/api/issues/17

## [1.24.0] - 2022.03.30
Added:
- Model factories to make fake data;

## [1.23.0] - 2022.03.30
### Added:
- CRUD attribute_values (Атрибут значения)
- поле is_global в таблице атрибуты

## [1.22.0] - 2022.03.30
### Added:
- CRUD атрибут (attributes) товаров 

## [1.21.0] - 2022.03.30
### Added:
- добавлен метод GET /partner/v1/customers для получения списка покупателей;
- добавлен метод GET /partner/v1/customers/{customer_id};

## [1.20.0] - 2022.03.30
### Changed:
- исправлен метод POST /partner/v1/employees ;
- исправлен метод PATCH /partner/v1/employees/{employee_id} ;

## [1.19.0] - 2022.03.29
### Added:
- добавлен метод GET /partner/v1/my-companies для получения информации  партнеров по авторизованному пользователю;
- добавлен метод GET /partner/v1/my-companies/{partner_id};
- добавлен метод PATCH /partner/v1/my-companies/{partner_id};

### Removed:
- удален GET /partner/v1/partners;
- удален GET /partner/v1/partners/{partner_id};
- удален PATCH /partner/v1/partners/{partner_id};

## [1.18.0] - 2022.03.29
### Added:
- добавлен метод GET /partner/v1/partners для получения информации  партнеров по авторизованному пользователю;
- добавлен метод GET /partner/v1/partners/{partner_id};
### Changed:
- исправлена выборка по умолчанию прокси сотрудников партнера;

## [1.17.0] - 2022.03.25
### Added:
- добавлен метод GET /partner/v1/account для получения информации по авторизованному пользователю;
- добавлен метод POST /partner/v1/account для изменения информации по авторизованному пользователю;
- добавлен метод DELETE /partner/v1/account для выхода из системы;
- добавлен метод GET /partner/v1/partners для получения списка объектов "Партнер" по авторизованному пользователю;
- добавлен метод GET /customer/v1/account для получения информации по авторизованному пользователю;
- добавлен метод POST /customer/v1/account для изменения информации по авторизованному пользователю;
- добавлен метод DELETE /customer/v1/account для выхода из системы;

### Changed:
- убран метод POST /partner/v1/auth/logout ;
- изменен метод POST /partner/v1/auth , теперь метод в json формате;
- изменен метод POST /partner/v1/auth/{phone} , теперь метод в json формате;
- убран метод POST /admin/v1/auth/logout ;
- изменен метод POST /admin/v1/auth , теперь метод в json формате;
- изменен метод POST /admin/v1/auth/{phone} , теперь метод в json формате;
- убран метод POST /customer/v1/auth/logout ;
- изменен метод POST /customer/v1/auth , теперь метод в json формате;
- изменен метод POST /customer/v1/auth/{phone} , теперь метод в json формате;

## [1.16.0] - 2022.03.23
### Added:
- Отмена уникальных полей phone в таблицах companies и partners;

### Changed:
- Изменён механизм создания сотрудников;

## [1.15.0] - 2022.03.22
### Added:
- добавлен метод GET /partner/v1/employees , реализована вся логика, т.е. отображаются только сотрудники авторизованного партнёра. Модель реализована черерз [Proxie]( https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html );
- добавлен метод POST /partner/v1/employees ;
- добавлен метод PATCH /partner/v1/employees/{employee_id} ;
- добавлен метод GET /partner/v1/employees/{employee_id} ;
- добавлен метод DELETE /partner/v1/employees/{employee_id} ;

## [1.14.0] - 2022.03.18
### Added:
- добавлен метод GET /partner/v1/companies , реализована вся логика. Модель реализована черерз [Proxie]( https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html );
- добавлен метод GET /partner/v1/companies/{company_id} , реализована вся логика;


## [1.13.1] - 2022.03.17
### Added:
- добавлен метод DELETE /admin/v1/partners , реализована вся логика;
- добавлен метод DELETE /admin/v1/partner-users/{partner_user_id} , реализована вся логика;

### Changed:
- изменен метод POST /admin/v1/partners , реализована вся логика;
- изменен метод PATCH /admin/v1/partner-users/{partner_user_id} , реализована вся логика;

## [1.13.0] - 2022.03.12
### Added:
- добавлен фильтр /admin/v1/roles/?filter[allow_manual]=true||false ;

### Changed:
- изменен метод PATCH /admin/v1/users при изменении ролей, реализована вся логика;
- запрет на блокировку суперадмин пользователя;
- изменен метод POST /admin/v1/company-users , реализована вся логика;
- изменен метод PATCH /admin/v1/company-users/{company_user_id} , реализована вся логика;
- изменен метод DELETE /admin/v1/company-users/{company_user_id} , реализована вся логика;
- изменен метод PATCH /admin/v1/companies/{company_id} , реализована вся логика;

## [1.12.1] - 2022.03.11
### Changed:
- генерация нового кода при авторизации для партнера и админа;

## [1.12.0] - 2022.03.11
### Added:
- добавлен фильтр /users/?filter[roles][name]=value ;
- добавлен фильтр /roles/?filter[name]=value ;
- добавлены новые роли (customerAdmin, customerEmployee, partnerAdmin, partnerEmployee), которые привязывются к пользователям программно;

### Changed:
- /roles только на получение списка и получение конкретной роли;
- /abilities только на получение списка и получение конкретной роли;
- обновлена логика работы методов создания партнеров и компаний;

## [1.11.1] - 2022.03.09
### Changed:
- переделан метод авторизации по номеру телефона для фронт-админ /auth 
- переделан метод подтверждения номера телефона для фронт-админ /auth/{phone} 
- переделан метод "выход из системы" для фронт-админ /auth/logout

## [1.11.0] - 2022.03.07
### Added:
- Добавлен файл с миграцией с пользователем по умолчанию, ролями и правами;
- Переделан механизм авторизации в зависимости от роли пользователя;

## [1.10.0] - 2022.03.05
### Added:
- Добавлен файл с миграцией с пользователем по умолчанию, ролями и правами;

## [1.9.0] 28.02.2022
### Added:
- Partner api
- CRUD сотрудник

## [1.8.3] 28.02.2022
### Added:
- JsonApi server для партнера
- Company schema для партнёры

## [1.8.3] 27.02.2022
### Added:
- Создать компании с помощи телефон

## [1.8.2] 26.02.2022
### Added:
- Привязка роли и прав к пользователям

## [1.8.1] 18.02.2022
### Changed:
- Большое изменение в файловой структуре
- Создать пользователь в сервисе, а не в контроллере

## [1.8.0] 18.02.2022
### Added:
- Сотрудники партнёра. 
- Список, редактирование, создание и удаление

## [1.7.0] 18.02.2022
### Added:
- Сотрудники компании. 
- Список, редактирование, создание и удаление
  
### Changed: 
- поля инфо в таблице компании и партнеры

## [1.6.0] 17.02.2022
### Added:
- Партнёры.
- Список, просмотр, создание, редактирование и удаление.
- Блокировка

### Changed:
- User request

## [1.5.0] 16.02.2022
### Added:
- Компании
- Список, просмотр, создание, редактирование и удаление;
- Блокировка;

## [1.4.0] 15.02.2022
### Added:
- Пользователи
  - Список, просмотр, создание, редактирование и удаление;
  - блокировка

## [1.3.0] 15.02.2022
### Added:
- Роли и права. 
- Список, просмотр, создание, редактирование и удаление. 
- Привязка прав к ролям
- Создать dto и сервис класс через командную консоль
- `php artisan make:dto --folder={Admin, Partner or Customer}`
- `php artisan make:service --folder={Admin, Partner or Customer}`

## [1.2.1]  12.02.2022
### Changed:
- Проверко в UserPolicy в метод update

## [1.2.0]  12.02.2022
### Added:
- Просмотр и редактирование своего профиля issue #2

## [1.1.0] 11.02.2022
- Авторизация(регистрация) по смс и выход из системы #1

## [1.0.3] 11.02.2022
### Added:
- Installed laravel-json-api/laravel

### Changed:
- gitignore

## [1.0.2] 09.02.2022
### Added:
- Laravel Ide-helper

## [1.0.1] 09.02.2022
### Added:
- Laravel sanctum

## [1.0.0] 09.02.2022
### Added:
- Installed laravel v8.6.3
