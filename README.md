Тестовое задание
============================
реализовать данную задачу с использованием фрэймворка Yii2

Написать модуль редактирования и вывода новостей


Модуль создания и редактирования новостей (админиский модуль):

Вывод всех новостей с сортировкой по дате(последние сверху)
Создание и редактирование новостей
У каждой новости есть поля: название, дата публикации, текст, тема(новость привязывается к одной теме из списка)
Для редактирования поля дата использовать календарь jquery (http://jqueryui.com/)


Модуль вывода новостей

Слева вывод всех годов для которых есть публикации, для каждого года вывод месяцев в которых были публикации в скобках указывается количество публикаций за этот месяц, в виде

2010
  сентябрь (1)
  июль (4)
  июнь (7)
  март (12)
  февраль (3)

2009

при нажатии на год вывод всех новостей этого года, при нажатии на месяц вывод всех новостей этого месяца.

под годами вывод всех тем, в скобках количество публикаций по теме

тема1 (2)
тема2 (5)
тема3 (7)

при клике на название темы показываются все новости для которых выбрана эта тема



справа вывод всех новостей в виде

Название
дата публикации, тема
Краткий текст(полный текст обрезанный 256символов) ...
                                             читать далее(ссылка на новость)

при клике на "читать далее" показывается новость в виде

Название
дата публикации, тема
Ткст новости полностью

				все новости (ссылка на страницу с новостями)


вывод новостей по 5 на страницу, внизу страницы пейджер(вывод всех страниц, текущая страница подсвечивается)


Выполнено
-------------------

 Дамп базы данных testid20.sql
Наcтройка соеденения с базой данных /config/db.php
Вход на сайт(чтоб попасть в редактирование новостей) логин:admin пароль:admin
```

**NOTES:**
На время тестировапния отключён кеш в конфиге.
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DummyCache',
        ],
