# Dhii - Module Interface

[![Build Status](https://travis-ci.org/Dhii/module-interface.svg?branch=develop)](https://travis-ci.org/Dhii/module-interface)
[![Code Climate](https://codeclimate.com/github/Dhii/module-interface/badges/gpa.svg)](https://codeclimate.com/github/Dhii/module-interface)
[![Test Coverage](https://codeclimate.com/github/Dhii/module-interface/badges/coverage.svg)](https://codeclimate.com/github/Dhii/module-interface/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/module-interface/version)](https://packagist.org/packages/dhii/module-interface)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]

## Details
This package contains interfaces that are useful in describing modules and their attributes and behaviour.

### Interfaces
- [`ModuleInterface`][] - The interface for a module. A module is an object that represents an
application fragment. Modules are prepared using `setup()`, which returns a `ServiceProviderInterface` instance that
the application may consume, and invoked using `run()`.
 
### Requirements
- PHP: 7.1 and up, until 8.

    Officially supports at least up to php 7.4.x.


[Dhii]: https://github.com/Dhii/dhii

[`ModuleInterface`]: src/ModuleInterface.php
