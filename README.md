# fXmlRpc Serialization

[![Latest Version](https://img.shields.io/github/release/fxmlrpc/serialization.svg?style=flat-square)](https://github.com/fxmlrpc/serialization/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/fxmlrpc/serialization.svg?style=flat-square)](https://travis-ci.org/fxmlrpc/serialization)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/fxmlrpc/serialization.svg?style=flat-square)](https://scrutinizer-ci.com/g/fxmlrpc/serialization)
[![Quality Score](https://img.shields.io/scrutinizer/g/fxmlrpc/serialization.svg?style=flat-square)](https://scrutinizer-ci.com/g/fxmlrpc/serialization)
[![HHVM Status](https://img.shields.io/hhvm/fxmlrpc/serialization.svg?style=flat-square)](http://hhvm.h4cc.de/package/fxmlrpc/serialization)
[![Total Downloads](https://img.shields.io/packagist/dt/fxmlrpc/serialization.svg?style=flat-square)](https://packagist.org/packages/fxmlrpc/serialization)

**Serialization logic for fXmlRpc.**


## Install

Via Composer

``` bash
$ composer require fxmlrpc/serialization
```


## Usage

This is the contract package for serialization logic used in fXmlRpc.

Currently the following implementations are available:

- Native: Uses XML-RPC extension
- XML Reader: Custom XML reading logic utilizing bitmasks


The implementations above provide `fxmlrpc/serialization-implementation` virtual package which is versioned together with the contract package.

For performance tests check the [benchmarks](https://github.com/fxmlrpc/benchmarks) repository.


## Testing

``` bash
$ phpspec run
```


## Security

If you discover any security related issues, please contact us at [security@fxmlrpc.org](mailto:security@fxmlrpc.org).


## Credits

- [Lars Strojny](https://github.com/lstrojny)
- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/fxmlrpc/serialization/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
