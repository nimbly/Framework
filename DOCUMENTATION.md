# Nimbly Framework

## Quick start

###

### JWT configuration

JWT support is provided out of the box with [Proof](https://github.com/nimbly/Proof). This library supports signing & verifying JWTs with HMAC and keypair.

By default, an HTTP middleware is provided that will check for a JWT in the `Authorization` header and, if present, attempt to decode and validate it. If the JWT is present and valid, it will be decoded into a `Nimbly\Proof\Token` instance and attached as a `ServerRequest` attribute.

In order to create and verify signed JWTs, you *must* provide a signing option within the configuration file.

You can configure your signing option along with other options within `config/jwt.php`.

#### Key pair

If you do not already have a key pair, you can create a set by running the `jwt:keypair` command. This is fine for running locally and when developing, however, your production credentials should be generated separately.

```bash
php cmd jwt:keypair
```

This will create an OpenSSL generated key pair (RSA, 4096 bits) with the contents of the keys base64 encoded as the following environment variables:

`JWT_PRIVATE_KEY`
`JWT_PUBLIC_KEY`

The keys will also be made available in plain text within the `keys/` directory. This directory is excluded from git by default (via `.gitignore`).

#### HMAC

If you would prefer to use HMAC (shared secret), you can generate your own secret by running `jwt:hmac`.

```bash
php cmd jwt:hmac
```

This will create a secure secret, base64 encoded, and made available in the following environment variable:

`JWT_HMAC_SECRET`

**NOTE:** As a reminder, any JWT signing keys or secrets (excluding public keys) are highly sensitive and should not be committed to your repository, even when base64 encoded (encoding does not equal encryption), and even if a private repository.

# Quick overview

Goals:

* Service based applications (no front end/UI)
* Schema first API architecture
	* Guaranteed API contract
	* Eliminate boilerplate request body validation in handlers
	* Auto generate API documentation
	* Create SDKs for customer
* Message consuming
	* Queue or pub sub
* Job scheduler
* Segregation of transport layer and core application logic
* JWT support out of the box
* Docker support out of the box
	* Dockerfile for HTTP using React/Http
	* Dockerfile for event processing
	* Dockerfile for job scheduler

## Folder layout

At first glance, the folder layout should not look too unfamiliar if you have worked with other PHP frameworks.

```bash
app/
	Core/
		Events/
		Models/
		Providers/
		Subscribers/
	Http/
		Handlers/
		Providers/
		Middleware/
	Consumer/
		Handlers/
		Providers/
	Scheduler/
		Handlers/
		Providers/
config/
routes/
bootstrap.php
```

One slight difference is the clear segregation of concerns within the `app` folder between core application code and logic and the various message transport layers: `Http`, `Consumer`, and `Scheduler`.

### Application

* `app/Core` This folder contains all core code for your service/application. The code in here is (and should be) independent from transport layer (HTTP, event bus, etc): models, events, subscribers, services, utilities and helpers, etc. This is the heart and core of your application and is shared between all message transports.
* `app/Http` This folder contains all code that is coupled to the HTTP transport layer: handlers (aka controllers), middleware, etc. Handlers should be lean and contain no business logic. Its purpose should be to take the incoming HTTP request and pull out the needed bits to pass off to the core application.
* `app/Consumer` This folder contains all code that is coupled to the event bus transport layer. Similar to `app/Http`, its handlers should be lean and contain no business logic. Its purpose is to take messages off the message bus and pull out the needed bits to pass off to the core application.
* `app/Scheduler` This folder contains all code that is coupled to the job scheduler.

Within each folder above, you will find a `Providers` folder. This is where you can define your dependencies to be added to the dependency container. Core shared dependencies should be added to `app/Core/Providers` folder, HTTP specific dependencies should be added to the `app/Http/Providers` folder, etc.

See the **Dependency container** section below for more information.

### Configuration files

Configuration files can be found in the `config/` folder. These configuration files should return an array of key/value pairs.

Example using a `config/email.php` file:

```php
return [
	"account_id" => \getenv("EMAIL_ACCOUNT_ID"),
	"api_key" => \getenv("EMAIL_API_KEY"),
	"default_from" => "hello@example.com",
];
```

You may create new files, edit, or extend existing configuration files to suit your needs.

You may reference configuration values at runtime by using the `\config(string $key)` global function, where the key is in the format `file name.property`.

Example:

```php
$email_api_key = \config("email.api_key");
```

In this example, the value will be attempted to be read from the `config/email.php` file and return the `api_key` property in the array.

You can retrieve nested properties by using dot notation.

Example `config/aws.php` file:

```php
return [
	"sqs" => [
		"url" => \getenv("AWS_SQS_URL")
	]
];
```

```php
$value = \config("aws.sqs.url");
```

If you want the entire contents of a configuration file, just use the base file name.

For example:

```php
$email_configuration = \config("email");
```

### Routes

Your HTTP routes can be found in the `routes/` folder. A `default.php` route file is created for you, but you are free to edit, rename, or delete this route file if you wish. You can add as many route files as you wish.

Registering (or de-registering) your routes will require you to edit the `config/http.php` file in the `routes` section.

## Dependency container

Create a class that implements the `Nimbly\Carton\ServiceProviderInterface`. You can define the dependecy as either a `singleton` or `factory`.

For example, we need to add our email service provider's SDK to the dependency container so that we may send trigger emails in certain circumstances.

We'll add a `app/Core/Providers/EmailProvider.php` file with the following contents:

```php
class EmailProvider implements ServiceProviderInterface
{
	public function register(Container $container): void
	{
		$container->singleton(
			EmailService::class,
			function(Container $container): EmailService {
				return new EmailService(
					\config("email.account_id"),
					\config("email.api_key")
				);
			}
		);
	}
}
```

A `singleton` will create just one instance of the dependency and use that instance any time it is requested from the container. A `factory` will create a new instance each time it is requested from the container.

### Registering dependencies

Once you've created your dependency in the `Providers`, you will need to register it in either:

* `config/app.php`
* `config/http.php`

## HTTP
### Handlers
Your HTTP handlers (also called controllers) can be placed anywhere you like, however the default location is in the `app/Http/Handlers` folder.

These handlers do not need to extend from any base class or implement any interfaces.

Once the handlers are attached to the appropriate routes (see below), Limber will automatically call them and attempt to auto-inject any dependencies for you.

Example:

```php
class BooksHandler
{
	public function getById(BookRepository $repository, string $id): JsonResponse
	{
		$book = $repository->findById($id);

		if( $book === null ){
			throw new NotFoundHttpException("Book not found.");
		}

		return new JsonResponse(
			ResponseStatus::OK,
			$book
		);
	}
}
```

If we assume the `BookRepository` was added to the dependency container, then in this example, both the `$repository` instance and the `$id` from the URI will be injected into the handler.

### Middleware

Limber ships with a set of common middleware that are all optional. You are free to create your own middleware that implement the `MiddlewareInterface`.

By default, you place your custom middleware in `App/Http/Middleware` however, they can be anywhere you like.

To register your middleware as global (applied to *all* incoming HTTP requests), you can add it to the `config/http.php` file in the `middleware` section.

If your middleware is only necessary for certain routes or groups of routes, you add it to the route definition.

Example:

```php
$router->group(
	middleware: [
		App\Http\Middleware\MyCustomMiddleware::class
	],
	routes: function(Router $router): void {
		$route->get("books/{id}", "BooksHandler@get");
	}
);
```

### Routes

Routes define the HTTP endpoints for your application and which handler should receive that HTTP
request.

```php
$router->get("/books/{id}", "App\\Http\\Handlers\\BooksHandler@getById");
```

The routes are defined within the `routes/` folder in one or more files.

#### HTTP methods

You can use any HTTP method for your routes using the builtin helper methods:

```php
$router->get();
$router->post();
$router->put();
$router->patch();
$router->delete();
```

Alternatively, you can use the `add` method to define any number of HTTP methods to respond to on a single handler.

```php
$router->add(["post","get"], "/books", "BooksHandler@books");
```

#### HTTP endpoints

#### HTTP handlers

Your handler (also known as controller) can be one of the following:

* A string of the format `ClassName@method`. For example: `BooksHandler@getById`.
* Any PHP callable
	* A callback/anonymous function or closure
	* An array containing class instance and method name or class name and static method name
	* An invokable class instance


Using a string in the format `ClassName@method`:

```php
$router->get("books/{id}", "BooksHandler@getById");
```

Using a callback:

```php
$router->get(
	"books/{id}",
	function(BookRepository $repository, string $id): Response {
		$book = $repository->findById($id);

		if( empty($book) ){
			throw new NotFoundHttpException("Book not found.");
		}

		return new JsonResponse(ResponseStatus::OK, $book);
	}
);
```

Using a class name and static method:

```php
$router->get("books/{id}", [BooksHandler::class, "getById"]);
```

#### Grouping routes

You can group routes together that share a common set of behaviors or configurations. When grouping routes, you can define:

* `routes` ***required, callback*** A callback that takes an instance of the `Nimnly\Limber\Router` class. Within this callback, you can define your routes that will inherit the group settings.
* `prefix` *optional, string* A string prepended to all URIs when matching the request.
* `namespace` *optional, string* The base namespace where handlers can be found. If not defined here, you will need to supply a fully-qualified namespace for the handlers.
* `middleware` *optional, array<class-name|instances>* An array of middleware to be applied to all routes defined in the group. This is the only option that has a cascading effect into nested groups.
* `scheme` *optional, string, enum["http", "https"]* The HTTP scheme (http or https) to match against. A null value will match against any value.
* `hostnames` *optional, array<string>* An array of hostnames to be matched against.
* `attributes` *optional,array<string,mixed>* An array of key=>value pairs representing attributes that will be attached to the `ServerRequestInterface` instance if the route matches.

Example:

```php
$router->group(
	prefix: "v1",
	namespace: "App\\Http\\Handlers",
	middleware: [
		AdminRequiredMiddleware::class,
	],
	schemes: ["https"],
	hostnames: ["admin.library.org"],
	routes: function(Router $router): void {
		$router->get("books", "BooksHandler@all");
		$router->get("books/{id:uuid}", "BooksHandler@getById");
	}
);
```

Route groups may be nested within other route groups.

#### Path parameters

You can define path parameters for your routes using curly braces.

For example:

```php
$router->patch("books/{id}", "BooksHandler@update");
```

In this example, `id` will match *any* value.

Often, you want to be more restrictive in what kind of values are deemed acceptable for a path
parameter. For example, if you are using integer values for IDs, you can restrict the path parameter
like this:

```php
$router->patch("books/{id:int}", "BooksHandler@update");
```

Limber comes with several built-in filters:

* `alpha` Any alpha character (a-z), case insensitive
* `int` Any numeric digit (0-9)
* `alphanumeric` Any alpha or numeric digit, case insensitive
* `uuid` A UUID/GUID, for example: 17f81c1d-4dde-42d9-9bf2-5427c06bfee3
* `hex` Hexidecimal value (0-9, a-f), case insensitive

You can create your own custom filter pattern by calling the `Nimbly\Limber\Router::setPattern()` static method.

Example:

```php
Router::setPattern("isbn", "\d{9}[\d|X]");

$router->patch("books/{id:isbn}", "BooksHandler@updateByIsbn");
```

### Exception Handling

Limber Framework comes with a prebuilt exception handler that will return a JSON response any time an uncaught exception is bubbled up.

For the structure of the error message, please refer to `#/components/responses/DefaultError` with the `openapi.json` file.

You can create a custom exception handler by simply implementing the `Nimbly\Limber\ExceptionHandlerInterface` and registering it to the dependency container.

## Events

Events can be triggered anywhere in your code. Events can be any object you like but are typically "value" objects. The default location for events is in the `App\Core\Events` folder, however your events can be stored anywhere you like.

Processing events is a blocking call. Any subscribers that take action on events will be processed in the order they were defined.

### Subscribers

An event isn't any good on its own. You need code that will process those events. This is known as a "subscriber." A subscriber is a class that can have one or more methods that will process events.

The event dispatcher is capable of depdency injection. This means anything from the container can be
used as a parameter for your subscribers, including the event itself.

To subscribe individual methods to one or more events, use the `Nimbly\Announce\Subscribe` attribute above the function definition3.

```php
class RegistrationSubscriber
{
	#[Subscribe(UserCreatedEvent::class)]
	public function onUserCreated(UserCreatedEvent $event, EmailService $email): void
	{
		$email->send(
			$event->getUser()->name,
			$event->getUser()->email,
			"templates/email/registration.tpl"
		);
	}
}
```

### Registering subscribers

In order for your subscriber to be added to the list of listening subscribers, add it to the `event.subscribers` configuration found in `config/event.php`.