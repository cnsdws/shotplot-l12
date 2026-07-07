Firestring references ballistic_profile_id.
Ammo/load is not stored at match level.
Rifle-distance defaults can later auto-fill the firestring load.

## Ballistic Profiles

A Ballistic Profile represents the ammunition/load used for a firestring.

Firestrings reference ballistic profiles directly because shooters may use different ammunition in different stages of the same match.

Relationship:

Match
  └── Firestrings
        └── Ballistic Profile

Ballistic profiles may represent either factory ammunition or handloads.

System profiles have user_id = null and is_system = true.
User-created profiles have user_id = the owner's user id.

Future rifle/distance defaults may auto-select a ballistic profile when creating a firestring, but the shooter can override it.

# Domain Standards

## Domain Layout

Contracts/
Data/
DTOs/
Models/
Repositories/
Services/
Tests/

Every domain follows the same structure.

---

## Business Logic

Business rules live in Services.

Controllers orchestrate only.

Views contain no business logic.

---

## IDs

Every reusable definition has a permanent ID.

Example:

200-slow-standing

Names may change.
IDs never do.

---

## Reference Data

Static definitions live under Data/.

Examples:

target_definitions.php
position_definitions.php
nra_high_power.php

These files contain data only.
No executable code.

---

## Dependency Rules

Domains communicate through Services and Contracts.

Domains never read another domain's Data directly.
