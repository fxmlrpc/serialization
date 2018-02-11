# FXMLRPC Serialization

[![Latest Version](https://img.shields.io/github/release/fxmlrpc/serialization.svg?style=flat-square)](https://github.com/fxmlrpc/serialization/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/fxmlrpc/serialization.svg?style=flat-square)](https://travis-ci.org/fxmlrpc/serialization)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/fxmlrpc/serialization.svg?style=flat-square)](https://scrutinizer-ci.com/g/fxmlrpc/serialization)
[![Quality Score](https://img.shields.io/scrutinizer/g/fxmlrpc/serialization.svg?style=flat-square)](https://scrutinizer-ci.com/g/fxmlrpc/serialization)
[![Total Downloads](https://img.shields.io/packagist/dt/fxmlrpc/serialization.svg?style=flat-square)](https://packagist.org/packages/fxmlrpc/serialization)

**Serialization logic for FXMLRPC.**


## Install

Via Composer

``` bash
$ composer require fxmlrpc/serialization
```


## Usage

This is the contract package for serialization logic used in FXMLRPC.

Currently the following implementations are available:

- Native: Uses XML-RPC extension
- XML Reader: Custom XML reading logic utilizing bitmasks
- Zend Framework 1 Adapter
- Zend Framework 2 Adapter


## How fast is it really?

IO performance is out of reach from a userspace perspective, but parsing and serialization speed is what matters.
How fast can we generate the XML payload from PHP data structures and how fast can we parse the servers response?
FXMLRPC uses stream based XML writers/readers to achieve it’s performance and heavily optimizes (read uglifies) for it.
As a result the userland version is only around 2x slower than the native C implementation (ext/xmlrpc).


```
8 subjects, 80 iterations, 320 revs, 0 rejects
min mean max: 11,497.750 118,279.634 339,007.500 (μs/r)
⅀T: 37,849,483.000μs μSD/r 5,275.433μs μRSD/r: 6.047%

+-----------------+-----------------------+-------+------+-----+-------------+----------------+----------------+----------------+---------------+--------+
| benchmark       | subject               | group | revs | its | mem         | min            | mean           | max            | stdev         | rstdev |
+-----------------+-----------------------+-------+------+-----+-------------+----------------+----------------+----------------+---------------+--------+
| ParserBench     | benchNativeParser     |       | 40   | 10  | 15,644,120b | 118,311.2500μs | 123,752.2250μs | 127,034.7500μs | 2,196.4803μs  | 1.77%  |
| ParserBench     | benchSaxParser        |       | 40   | 10  | 15,594,984b | 144,438.0000μs | 149,607.9000μs | 157,309.2500μs | 3,892.3376μs  | 2.60%  |
| ParserBench     | benchZend1Parser      |       | 40   | 10  | 56,360,640b | 281,302.0000μs | 299,799.0750μs | 339,007.5000μs | 18,533.0495μs | 6.18%  |
| ParserBench     | benchZend2Parser      |       | 40   | 10  | 56,321,216b | 278,974.5000μs | 287,957.9750μs | 317,007.5000μs | 10,655.0098μs | 3.70%  |
| SerializerBench | benchNativeSerializer |       | 40   | 10  | 12,420,416b | 11,497.7500μs  | 12,464.6500μs  | 15,255.5000μs  | 1,416.8554μs  | 11.37% |
| SerializerBench | benchSaxSerializer    |       | 40   | 10  | 15,460,152b | 22,643.2500μs  | 24,231.8250μs  | 26,539.7500μs  | 1,411.6560μs  | 5.83%  |
| SerializerBench | benchZend1Serializer  |       | 40   | 10  | 15,761,968b | 21,869.7500μs  | 24,352.1750μs  | 29,988.2500μs  | 2,149.4408μs  | 8.83%  |
| SerializerBench | benchZend2Serializer  |       | 40   | 10  | 15,671,376b | 21,832.5000μs  | 24,071.2500μs  | 28,176.2500μs  | 1,948.6380μs  | 8.10%  |
+-----------------+-----------------------+-------+------+-----+-------------+----------------+----------------+----------------+---------------+--------+
```


Run `./vendor/bin/phpbench run --report=custom` to execute the benchmarking test suite.


## Zend Incompatibility list

Zend is not fully compatible with the rest of the serializers and parsers.


### Parser incompatibility

- Automatically decodes Base64 encoded values
- Does not return DateTime objects
- Cannot return empty DateTime values
- Does not support Apache Nil
- Incorrectly detects invalid multiple parameters
- Cannot parse response containing an [XXE Attack](https://en.wikipedia.org/wiki/XML_external_entity_attack)


### Serializer incompatibility

- If no params are passed, no empty params tag is generated
- Unlike the xmlrpc extension, Zend does not add [newlines](http://php.net/manual/en/function.xmlrpc-encode-request.php#27992)



## Testing

``` bash
$ composer test
```


## Security

If you discover any security related issues, please contact us at [security@fxmlrpc.io](mailto:security@fxmlrpc.org).


## Credits

- [Lars Strojny](https://github.com/lstrojny)
- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/fxmlrpc/serialization/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
