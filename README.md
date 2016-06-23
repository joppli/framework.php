#   Joppli  v.0.1

### PHP Framework

Licence: [Do What The Fuck You Want To Public License (WTFPL)](http://www.wtfpl.net/about/).

---

This documentation is very basic, the framework is developed by me to use by my self. If an intrest is shown by others I will extend the documentation. Show intrest by dropping me a line on twitter [@ErikLandvall](https://twitter.com/ErikLandvall) or simply star/follow/fork the project.

Specific caracter of the framework: the possibility to use a series of dispatchers on each request.


## Skeleton

```
root
├─ config
│  └─ config.yml
├─ public
│  └─ index.php
├─ src
|  └─ HelloWorld
|     └─ HelloWorldDispatcher.php
└─ composer.json
```

### config/config.yml

The config file be of what ever flavor. I prefer the [YAML](http://yaml.org/), why I use that.

#### Basic example:

```yaml
---
route:
- deliverer: Joppli\Deliverer\JsonDeliverer
- dispatchers:
  - Resource\User\Operation\Login\LoginUserDispatcher
  policy:
  - validator: PathCompareValidator
    options:
      path: /
  - validator: MethodValidator
      options:
        method: get
...
```

The config files branches are case insensitive, the leafs are not.

### public/index.php

```php
<?php

// Changes root directory
$root = dirname(__DIR__);
chdir($root);

// Auto loader
require 'vendor/autoload.php';

$config  = new Joppli\Config\Config(yaml_parse_file('config/config.yml'));
$request = (new Joppli\Request\RequestFactory)->create();

// Run application
(new Joppli\Application\ApplicationBuilder)->build($config, $request)->run();
```

### src/HelloWorld/HelloWorldDispatcher.php

```php
<?php

namespace HelloWorld;

use Joppli\Dispatcher\Dispatcher;
use Joppli\Request\Aware\RequestAware;
use Joppli\Request\Aware\RequestAwareTrait;
use Joppli\Response\Aware\ResponseAware;
use Joppli\Response\Aware\ResponseAwareTrait;

class HelloWorldDispatcher implements Dispatcher, RequestAware, ResponseAware
{
  use
    RouteAwareTrait,
    UserAwareTrait;

  public function dispatch()
  {
    $host = $this->request->getHost();
    
    $this->response->message = 'Hello world!';
    $this->response->host 	 = $host;
  }
}
```

### composer.json

```json
{
  "autoload":
  {
    "psr-4":
    {
      "HelloWorld\\": "src/HelloWorld"
    }
  },

  "require":
  {
    "joppli/php-framework": "*"
  }
}
```
