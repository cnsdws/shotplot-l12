# ADR 0004: Legacy Persistence Boundary

## Status

Accepted

## Decision

The current Firestring model and table are treated as a compatibility boundary.

New domain and planning objects do not mirror the legacy schema.

FirestringTemplate maps clean planning data into legacy persistence attributes through:

