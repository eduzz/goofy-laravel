
# Goofy

O Goofy é uma lib de estatísticas e metricas, é uma implementação que utiliza a lib **[Hermes](https://github.com/eduzz/hermes)** para enviar os dados para o **rabbitMQ**.

## Instalação

Primeiro, vamos adicionar a dependência e o repositório do **Goofy** e do **Hermes** no nosso arquivo composer.json:

```json
{
    "require": {
        "eduzz/hermes": "dev-master",
        "eduzz/goofy": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:eduzz/goofy-laravel.git"
        },
		{
            "type": "vcs",
            "url":  "git@github.com:eduzz/hermes.git"
        }
    ]
}
```

Após, vamos rodar o comando

```
composer dump-autoload
```

Para atualizar o cache do composer

```
composer install
```

Para instalar as dependência e o goofy

PS: É preciso verificar se você está com a chave conectada ao bitbucket no shell onde vai rodar o composer install.

### Instalação em projeto Laravel

O próximo passo é registrar o Goofy na lista de service providers, dentro do seu config/app.php, adicione o Goofy na sua lista de providers e adicione também a facade do Goofy na lista de aliases.

 ```php
'providers'  => [
	// ...
	Eduzz\Goofy\GoofyLaravelServiceProvider::class,
],
```

```php
'aliases'  => [
	// ...
	'Goofy'  =>  Eduzz\Goofy\Facades\GoofyFacade::class,
],
```

Precisamos limpar nosso cache, atualizar os pacotes e publicar a configuração do Goofy:

```bash
php artisan cache:config
composer update
php artisan vendor:publish --tag="config"
```

Se tudo ocorreu bem, a seguinte mensagem sera exibida:

```bash
Copied File [/vendor/eduzz/goofy/src/Config/goofy.php] To [/config/goofy.php]
```

Então, é necessário configurar o goofy, no arquivo config/goofy.php, nas variáveis queue_connection e application, por exemplo:

```php
return [
	'queue_connection'  =>  array(
		'host'  =>  env('RABBIT_HOST'),
		'port'  =>  env('RABBIT_PORT'),
		'username'  =>  env('RABBIT_USER'),
		'password'  =>  env('RABBIT_PASSWORD'),
		'vhost'  =>  env('RABBIT_VHOST'),
	),
	'application' => 'checkout'
]
```

### Instalação em projeto Lumen

Para instalação em projeto lumen, é preciso criar o arquivo de configuração na mão, vamos adicionar um arquivo chamado goofy na pasta config com o seguinte conteúdo:

```php
// Caso seja apenas store
return [
	'queue_connection'  =>  array(
		'host'  =>  env('RABBIT_HOST'),
		'port'  =>  env('RABBIT_PORT'),
		'username'  =>  env('RABBIT_USER'),
		'password'  =>  env('RABBIT_PASSWORD'),
		'vhost'  =>  env('RABBIT_VHOST'),
    ),

	'application' => 'checkout'
]
```

Vamos também adicionar nosso service provider no register, então na pasta bootstrap/app.php, procure pela linha que faz os registros e adicione:

```php
<?php
// ...
$app->register(Eduzz\Goofy\GoofyLaravelServiceProvider::class);
// ...
```

Adicione também a chamada para a configuração do goofy, por exemplo:

```php
<?php
$app->configure('goofy');

return $app;
```

### Instalação em um projeto sem framework Illuminate

Para utilizar o Goofy sem Laravel/Lumen, é necessário setar as configurações na mão, exemplo:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
use Eduzz\Goofy\Goofy;
use Eduzz\Hermes\Hermes;

$hermes = new Hermes([
    'host' => 'localhost',
    'port' => 5672,
    'username' => 'guest',
    'password' => 'guest',
    'vhost' => '/'
]);

$goofy = new Goofy('checkout', $hermes);

```

# Usage

```php
<?php

$goofy->publish(
    '00000000000000000000000000000000',
    'test',
    'xpto',
    [
        "name" => "carlos",
        "id" => 50
    ]
);

```
