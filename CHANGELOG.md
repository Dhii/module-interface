# Change log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [[*next-version*]] - YYYY-MM-DD

## [0.3.0-alpha1] - 2021-01-14
### Added
- Support for PHP 8.
- **BC-breaking**: `ModuleInterface#run()` now declares `void` return type.

## [0.2.0-alpha1] - 2020-04-10
### Changed
- Module `setup()` now returns a `ServiceProviderInterface` instance.
- Module `run()` now requires the `ContainerInterface` argument.
- Modules are no longer key-aware.

### Removed
- `DependenciesAwareInterface` has been removed.
- `ModuleFactoryInterface` has been removed.
- `ModuleKeyAwareInterface` has been removed.

## [0.1] - 2019-11-05
Stable release

### Fixed
- Modules are now allowed to throw specialized exceptions.

## [0.1-alpha1] - 2018-05-07
Initial version.
