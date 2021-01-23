# pQuery - jQuery style DOM traversal, in PHP

[![Build Status](https://www.travis-ci.com/iamcal/pquery.svg?branch=main)](https://www.travis-ci.com/iamcal/pquery)
[![Coverage Status](https://coveralls.io/repos/github/iamcal/pquery/badge.svg?branch=main)](https://coveralls.io/github/iamcal/pquery?branch=main)
[![Latest Stable Version](http://img.shields.io/packagist/v/iamcal/pquery.svg?style=flat)](https://packagist.org/packages/iamcal/pquery)

**Beware!** There are several projects with the name pQuery. You might be looking for a different one.

This PHP library allows you to use jQuery-style selectors to find DOM nodes in HTML documents.
It uses the PHP DOM classes under the covers, which ultimately use libxml for document parsing.


## Installation

You can install using composer:

    composer require iamcal/pquery

This will put the pQuery class into the autoloader in `vendor/autoload.php`.

Alertnatively you can clone this repo and include `src/pQuery.php` directly.


## Basic Usage

    $html = '<p>Hello <b>World</b></p>';

    $pq = pQuery::fromHTML($html);

    $nodes = $pq->find('b');
    // $nodes is an array of DOMNode objects

Supported selectors:

    tag
    tag.class
    tag#id
    .class
    #id

Selectors can be chained together, e.g. `table#my-table th a.info`
