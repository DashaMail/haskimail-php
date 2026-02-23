<h1>Haskimail-PHP</h1>
Haskimail-PHP is the officially supported PHP library for Haskimail.
With Haskimail, you can send and receive emails effortlessly.
<h1>Requirements</h1>
PHP >=7.0.0
Guzzle HTTP client
<h1>Getting Started</h1>
 

```
// Sending email with Haskimail-PHP library
// Learn more -> https://haskimail.ru/developer/integration/official-libraries#php

// Install with composer
composer require dashamail/haskimail-php

// Import
use Haskimail\HaskimailClient;

// Example request
$client = new HaskimailClient("server token");

$sendResult = $client->sendEmail(
  "отправитель@example.com",
  "получатель@example.com",
  "Привет от Хаски!",
  "Это просто дружеский привет от пользователя Хаски!"
);
 ```
