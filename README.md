PHP Slack
=========
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/arthurkushman/slacky/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/arthurkushman/slacky/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/arthurkushman/slacky/badges/build.png?b=master)](https://scrutinizer-ci.com/g/arthurkushman/slacky/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/arthurkushman/slacky/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![codecov](https://codecov.io/gh/arthurkushman/slacky/branch/master/graph/badge.svg)](https://codecov.io/gh/arthurkushman/slacky)
> A lightweight PHP implementation of Slack's API.

### Why this lib was forked and recoded

- Legacy code (repo was left for > 2 years) didn't allow to support new features of PHP>=7.1
- Minor bugs and fragile functionality
- None unit-tests coverage 

### Provides

* Slacky\Contracts

    A small set of contracts to allow for the consumption of the Slack API. **Interactor**, **Response** and **ResponseFactory**.

    * **Interactor** is in charge of providing the Http GET/POST methods.
    * **Response** is in charge of providing a simple Http response wrapper for holding the body, headers and status code.
    * **ResponseFactory** is in charge of providing a factory to instantiate and build the **Response**.

To use this package, it's simple. Though _please note_ that this implementation is very lightweight meaning you'll need to do some more work than usual. This package doesn't provide methods such as `Chat::postMessage(string message)`, it literally provides one method (`Commander::execute(string command, array parameters = [])`).

Here is a very simple example of using this package:
```php
<?php

use Slacky\Http\SlackResponseFactory;
use Slacky\Http\CurlInteractor;
use Slacky\Core\Commander;

$interactor = new CurlInteractor;
$interactor->setResponseFactory(new SlackResponseFactory);

$commander = new Commander('xoxp-some-token-for-slack', $interactor);

$response = $commander->execute('chat.postMessage', [
    'channel' => '#general',
    'text'    => 'Hello, world!'
]);

if ($response['ok'])
{
    // Command worked
}
else
{
    // Command didn't work
}
```

Note that Commander will automatically format most inputs to Slack's requirements but attachments are not supported - you will need to manually call `$text = Commander::format($text)` to convert it.
