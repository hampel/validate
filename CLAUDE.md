# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

`hampel/validate` — a published Composer library of standalone validation helpers. No framework,
no runtime dependencies, one class.

## Commands

    composer install
    vendor/bin/phpunit                                  # whole suite
    vendor/bin/phpunit --filter testIsPublicIpv6        # one test
    vendor/bin/phpunit --display-deprecations           # deprecations are hidden by default

`composer.lock` is gitignored — this is a library, so the lock file is not authoritative and CI
would resolve fresh anyway.

## Architecture

`src/Validator.php` is the whole package: one class, `Hampel\Validate\Validator`, instantiated
rather than called statically (that changed in 2.0.0, and the old static API is gone).

Most methods are thin wrappers over `filter_var()` with the appropriate `FILTER_VALIDATE_*`
constant, normalising its mixed return to a strict boolean. `isIp`/`isPublicIp` are unions of the
v4 and v6 variants. **The consequence is that these methods inherit PHP's filter semantics,
including its bugs** — see the known failures below. Anything that looks like a validation quirk
should be checked against `filter_var()` directly before it is treated as a bug in this code.

The two exceptions are `isDomain` (a RegexBuddy internationalised-domain regex, punycode aware)
and `isTld` (string extraction plus `in_array` against a caller-supplied list).

**No TLD list is shipped.** 2.2.0 removed `getTlds()` and the `ManageTlds` class deliberately: the
caller passes an array of lowercase TLDs to `isDomain()`/`isTld()`, or passes nothing and gets
structural validation only. Sourcing that list is `hampel/tlds`' job; Laravel rule bindings are
`hampel/validate-laravel`'s. Do not reintroduce either concern here — the small dependency-free
surface is the point of the package.

`isTld` validates only the extension, never the domain: `isTld('---.com', $tlds)` is true while
`isDomain('---.com', $tlds)` is false. The tests assert this asymmetry on purpose.

## Conventions

Existing code is PHP 5-era in style and stays that way for BC: tabs, `<?php namespace Foo;` on one
line, no `declare(strict_types=1)`, no parameter or return types, `OR` rather than `||`, and
untyped `$value` parameters that accept anything `filter_var` accepts (including `null` and `int`,
which the tests exercise). Adding types to the public signatures is a breaking change, not
cleanup.

`composer.json` declares `php: >=7.2.0`. Supported versions are a policy decision rather than a
preference — do not widen or narrow that constraint as incidental cleanup.

Tests are one method per public method in `tests/ValidatorTest.php`, sharing the package namespace
(`autoload-dev` maps `Hampel\Validate\` to `tests/`), so no `use` is needed for the class under
test.

## Known failures

Two tests fail on PHP 8.3, both the same cause: the *compressed* documentation address
`2001:db8::ff00:42:8329` passes `FILTER_FLAG_NO_RES_RANGE` while the expanded
`2001:db8:0:0:0:ff00:42:8329` is correctly rejected. The library is doing what it always did; PHP's
reserved-range check does not recognise the compressed form.

`ValidatorTest` also triggers a dynamic-property deprecation — `$validator` is assigned in
`setUp()` without being declared.
