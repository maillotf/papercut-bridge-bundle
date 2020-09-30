# Papercut-bridge-bundle

Symfony bundle for Papercut XML-RPC client which is base on token authentication

## Required configuration

### Modify framework.yaml
```yaml
papercut:
    authentication:
        protocol: "http"
        host: "127.0.0.1"
        port: "80"
        path: "/rpc/api/xmlrpc"
        token: "TOKEN"
```

```yaml
papercut:
    authentication:
        path: "http://URL/rpc/api/xmlrpc"
        token: "TOKEN"
```

### Modify services.yaml
```yaml
services:
    MaillotF\Papercut\PapercutBridgeBundle\Service\PapercutService: '@papercut.service'
```

##Package instalation with composer

```console
$ composer require maillotf/papercut-bridge-bundle
```

## Use in controller:

```php
<?php
//...
use MaillotF\Papercut\PapercutBridgeBundle\Service\PapercutService;

class exampleController extends AbstractController
{
	/**
	 * Example
	 * 
	 * @Route("example", name="example", methods={"GET"})
	 * 
	 */
	public function test(PapercutService $ps)
	{
		$user = $ps->user->getUser('4665');
		
		return ($this->json($user->getEmail()));
	}

}
```