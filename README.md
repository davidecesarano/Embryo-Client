# Embryo Client
Simple PSR-18 HTTP Client.

## Requirements
* PHP >= 7.1

## Installation

Using Composer:
```
$ composer require davidecesarano/embryo-client
```

## Usage
You may use the `get`, `post`, `put`, `patch`, and `delete` methods provided by the Http Client factory. These methods returns an instance of `Psr\Http\Message\ResponseInterface`.

```php
use Embryo\Http\Client\ClientFactory;

$http = new ClientFactory;
$response = $http->get('https://example.com/');
```

When making `POST`, `PUT`, and `PATCH` requests you may send additional data to request with an array of data as their second argument.

```php
$response = $http->post('https://example.com/users', [
    'name' => 'Davide',
    'surname' => 'Cesarano'
]);
```

### Headers
Headers may be added to requests using the `withHeaders` method. This method accepts an array of key / value pairs:

```php
$response = $http
    ->withHeaders([
        'X-First' => 'foo',
        'X-Second' => 'bar'
    ])
    ->post('https://example.com/users', [
        'name' => 'Davide',
        'surname' => 'Cesarano'
    ]);
```

### Bearer Token
If you would like to quickly add a bearer token to the request's `Authorization` header, you may use the `withToken` method:

```php
$response = $http
    ->withToken('token')
    ->post('https://example.com/users', [
        'name' => 'Davide',
        'surname' => 'Cesarano'
    ]);
```

### Sending a raw request body
You may use the `withJson` method if you want to provide a raw request body when making a request:

```php
$response = $http
    ->withJson()
    ->post('https://example.com/users', [
        'name' => 'Davide',
        'surname' => 'Cesarano'
    ]);
```

### Attach file
If you want to send files, you may use the `withFile` method. This method accepts the name of the field and file absolute path:

```php
$response = $http
    ->withFile('file1', '/path/to/file1')
    ->withFile('file2', '/path/to/file2')
    ->post('https://example.com/upload');
```

### Timeout
With `timeout` method you may to specify the maximum number of seconds to wait for a response:

```php
$response = $http
    ->withTimeout(30)
    ->get('https://example.com/users');
```