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
