![tests](https://github.com/jeyroik/extas-operations-jsonrpc-update/workflows/PHP%20Composer/badge.svg?branch=master&event=push)
![codecov.io](https://codecov.io/gh/jeyroik/extas-operations-jsonrpc-update/coverage.svg?branch=master)
<a href="https://github.com/phpstan/phpstan"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>
<a href="https://codeclimate.com/github/jeyroik/extas-operations-jsonrpc-update/maintainability"><img src="https://api.codeclimate.com/v1/badges/90cf5e0120eb48cb8f31/maintainability" /></a>
<a href="https://github.com/jeyroik/extas-installer/" title="Extas Installer v3"><img alt="Extas Installer v3" src="https://img.shields.io/badge/installer-v3-green"></a>
[![Latest Stable Version](https://poser.pugx.org/jeyroik/extas-operations-jsonrpc-update/v)](//packagist.org/packages/jeyroik/extas-jsonrpc)
[![Total Downloads](https://poser.pugx.org/jeyroik/extas-operations-jsonrpc-update/downloads)](//packagist.org/packages/jeyroik/extas-jsonrpc)
[![Dependents](https://poser.pugx.org/jeyroik/extas-operations-jsonrpc-update/dependents)](//packagist.org/packages/jeyroik/extas-jsonrpc)


# Описание

Update operation for JSON RPC

# Спецификация

```json
{
  "request": {
    "type": "object",
    "properties": {
      "data": {
      		"type": "object",
      		"items": {"type": "mixed"}
      	}
    }
  },
  "response" : {
    "type" : "object",
    "properties" : {
       "type": "object",
       "items": {"type": "mixed"}
    }
  }
}
```

# Пример запроса

```json
{
  "id": "2f5d0719-5b82-4280-9b3b-10f23aff226b",
  "method": "snuff.update",
  "params": {
    "data": {
      "name": "test",
      "description": "new value"
    }
  }
}
```