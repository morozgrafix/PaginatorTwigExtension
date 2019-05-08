# PaginatorTwigExtension
Twig extension to help generate simple paginations in Twig templates.

[![Latest Stable Version](https://poser.pugx.org/morozgrafix/paginator-twig-extension/version)](https://packagist.org/packages/morozgrafix/paginator-twig-extension)
[![Latest Unstable Version](https://poser.pugx.org/morozgrafix/paginator-twig-extension/v/unstable)](//packagist.org/packages/morozgrafix/paginator-twig-extension)
[![Build Status](https://travis-ci.org/morozgrafix/PaginatorTwigExtension.svg?branch=master)](https://travis-ci.org/morozgrafix/PaginatorTwigExtension)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/morozgrafix/PaginatorTwigExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/morozgrafix/PaginatorTwigExtension/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/morozgrafix/PaginatorTwigExtension/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/morozgrafix/PaginatorTwigExtension/?branch=master)
[![License](https://poser.pugx.org/morozgrafix/paginator-twig-extension/license)](https://packagist.org/packages/morozgrafix/paginator-twig-extension)
[![composer.lock available](https://poser.pugx.org/morozgrafix/paginator-twig-extension/composerlock)](https://packagist.org/packages/morozgrafix/paginator-twig-extension)


# Introduction

This extension helps building pagination in [Twig](https://twig.symfony.com/) templates. It will return an array with all necessary information to quickly display pagination links. It doesn't generate any HTML and it's up to you how you'd like to display it. Example below shows one of the ways of generating pagination compatible with [Bootstrap CSS framework](https://getbootstrap.com/).

![Example1](../assets/images/example1.png?raw=true)

Extension is called with following function and accepts following parameters:

```php
paginator(int current_page, int last_page, int num_items, string separator)
```
### Parameters in detail:
- `current_page` - current page visitor is on
- `last_page` - last page in data set (total number of pages)
- `num_items` - number of items that will be displayed in a pagination strip. *Note:* minimum allowed value is 7 and if even number is passed it will be bumped to next odd number for symmetry.
- `separator` (optional) - custom separator for numbers not visible in pagination strip. Default is set to `...`

#### Basic example:

Calling 
```twig
{% set paginator = paginator(1, 10 , 7) %}
```
will set `paginator` twig variable to:

```php
array (
  'curr_page' => 1,
  'last_page' => 10,
  'num_items' => 7,
  'separator' => '...',
  'pagination' => array (
    0 => 1,
    1 => 2,
    2 => 3,
    3 => 4,
    4 => 5,
    5 => '...',
    6 => 10,
  ),
)
```


# Installation

Using [Composer](http://getcomposer.org):

```bash
composer require morozgrafix/paginator-twig-extension
```

# Logic in Twig template

Following example is compatible with [Bootstrap 4](https://getbootstrap.com/) CSS framework.

```twig
<nav aria-label="pagination">
    <ul class="pagination justify-content-center">
        {# Optional Prev #}
        <li class="page-item {% if paginator.curr_page == 1 %} disabled{% endif %}">
            <a class="page-link" href="?page={{ paginator.curr_page-1 }}">Prev</a>
        </li>

        {# Main Pagination Loop #}
        {% for i in paginator.pagination %}
            <li class="page-item{% if i == paginator.curr_page %} active{% endif %}{% if i == paginator.separator %} disabled{% endif %}">
                <a class="page-link" href="?page={{ i }}">{{ i }}</a>
            </li>
        {% endfor %}

        {# Optional Next #}
        <li class="page-item {% if paginator.curr_page == paginator.last_page %} disabled{% endif %}">
            <a class="page-link" href="?page={{ paginator.curr_page+1 }}">Next</a>
        </li>
    </ul>
</nav>
```


Result with optional `Prev`/`Next`:


![Example2](../assets/images/example2.png?raw=true)


Result without `Prev`/`Next`:


![Example3](../assets/images/example3.png?raw=true)

# Additional Examples

Custom separator:
```twig
{% set paginator = paginator(10, 25 , 11, '¯\_(ツ)_/¯') %}
```
Result:
```
array (
  'curr_page' => 10,
  'last_page' => 25,
  'num_items' => 11,
  'separator' => '¯\\_(ツ)_/¯',
  'pagination' => array (
    0 => 1,
    1 => '¯\\_(ツ)_/¯',
    2 => 7,
    3 => 8,
    4 => 9,
    5 => 10,
    6 => 11,
    7 => 12,
    8 => 13,
    9 => '¯\\_(ツ)_/¯',
    10 => 25,
  ),
)
```

![Example4](../assets/images/example4.png?raw=true)

Even number of items was specified, it gets bumped to next odd number for display symmetry (10 -> 11):
```twig
{% set paginator = paginator(420, 999 , 10) %}

```

Result:
```php
array (
  'curr_page' => 420,
  'last_page' => 999,
  'num_items' => 11,
  'separator' => '...',
  'pagination' => array (
    0 => 1,
    1 => '...',
    2 => 417,
    3 => 418,
    4 => 419,
    5 => 420,
    6 => 421,
    7 => 422,
    8 => 423,
    9 => '...',
    10 => 999,
  ),
)
```

![Example5](../assets/images/example5.png?raw=true)

# P.S.

This is my first Twig extension and it was quickly developed while I was working on a bigger project that needed pagination. I'm sure there are some pitfalls and additional features that can be added. Feel free to open an issue or submit a PR with improvements. Thanks. 🙇
