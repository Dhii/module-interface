# Change log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [[*next-version*]] - YYYY-MM-DD
### Changed
- **BC Breaking** - The return type of `ModuleInterface#run()` is now `void`.
    This will break any subtypes that did not declare a return type,
    because `void` is more specific than `mixed`.

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
