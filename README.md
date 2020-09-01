![tests](https://github.com/jeyroik/extas-operations-jsonrpc-update/workflows/PHP%20Composer/badge.svg?branch=master&event=push)
![codecov.io](https://codecov.io/gh/jeyroik/extas-operations-jsonrpc-update/coverage.svg?branch=master)
<a href="https://github.com/phpstan/phpstan"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>

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