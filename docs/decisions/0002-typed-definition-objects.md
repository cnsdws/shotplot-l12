# ADR 0002: Typed Definition Objects

## Status

Accepted

## Decision

Resolved shooting knowledge is represented by immutable typed definition objects rather than associative arrays.

Current examples:

- StageDefinition
- PositionDefinition
- TargetDefinition

## Rationale

Typed objects provide:

- explicit contracts,
- IDE support,
- safer refactoring,
- reduced key-name errors,
- clearer domain relationships,
- and a better foundation for analysis and coaching.

## Consequences

Raw PHP arrays may remain as source data temporarily, but services convert them into typed objects at the domain boundary.
