# Configuration

*Reference.* Why this pack has no config file, and where its settings live instead.

## No config file

This pack ships no config file, so there is no `ichava.icon-sets-simple-icons` key and no publish tag. The
scaffolder generates one holding only an `enabled` flag, a path and a cache switch, which nothing reads: core takes
the set name and prefix from `resources/assets/svg/config.json` through `IconsConstants`, as in `icon-sets-tabler`.
It was not kept.

## Where its settings live

`resources/assets/svg/config.json` is canonical for the pack's name, prefix, kind, variants and
categories, and core reads it when the provider registers the pack. A host changes behaviour through
core's configuration, below, not by editing the pack.

## Kinds in `config.json`

`resources/assets/svg/config.json` declares what this pack's SVGs are, `icon` or `illustration`. Core decides
each item's kind from the first row that gives one. An item path is the file's path under `files/` without
`.svg` (`github`):

| Row | Key | Notes |
|---|---|---|
| 1 | the host's `kinds.overrides` | the app developer's, in core's config; wins over the pack |
| 2 | `metadata.data.items.<item path>.kind` | one item; the value is an object so it can grow |
| 3 | `metadata.data.kinds.rules[]` | `{ "match": "<glob>", "kind": "..." }`, ordered, **first match wins** |
| 4 | `metadata.data.categories.<slug>.kind` | every item in that first-level folder |
| 5 | `package.kind` | the pack's default |
| 6 | | `icon` |

Globs match the whole item path and are case-sensitive: `*` is any run of characters except `/`, `?` is one
character, and `**` is whole segments. A pack is "mixed" when its items resolve to both kinds; nothing declares
that, and there is no `"kind": "mixed"`. A value that names no kind is ignored by core and reported by
`ichava::ichava-core.info doctor`. See core's [kinds guide](https://github.com/ichava/core/blob/main/docs/kinds.md).

This pack declares `package.kind: icon` and nothing else: no category kind, `items` or `kinds.rules` entry, so every item resolves `icon` from row 5. The `brands` category is declared for the browser's grouping and names no kind of its own.

`SvgKindTest` pins this against `config.json` and against core's resolver, so a typo here fails a test instead of
quietly filing SVGs as icons.

## The licence record

`config.json` also carries a `license` block: the SPDX id (`CC0-1.0`), the path of the upstream licence copy, its
SHA-256, and the upstream version and date it was checked. Core does not read it. It is there for the sync's
licence-change guard, which compares the upstream file at a new tag against this hash, and `AttributionTest` checks
the copy against it.

## What is not here

Cache, queue, database, logging, security and the `ICHAVA_*` environment surface are **core's**, and
apply to every pack at once. They are documented in core's
[configuration guide](https://github.com/ichava/core/blob/main/docs/configuration.md) and [environment variables](https://github.com/ichava/core/blob/main/docs/environment.md).

Nothing in this pack can change how core seeds, caches or sanitises; that is the point of the split.

---

[← Docs index](../README.md#documentation)
