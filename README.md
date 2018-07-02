## MegaData Demo ##

Демонстрационная библиотека для работы с вымышленным API. Позволяет подменять парсер ответов сервера и таким образом поддерживать несколько форматов ответа. В данном состоянии поддерживает только формат JSON.

Выполнена в виде бандла Symfony.

Для установки бандла добавьте в composer.json своего проекта строки:
```javascript
...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/k-pozdeev/megadata.git"
        }
    ],
    "require": {
...
        "mega-data/mega-data-bundle": "*@dev-master"
    },
    "minimum-stability": "dev"
```
Для проверки в пустом проекте:
```
composer create-project symfony/skeleton megadatatest
```
