#!/bin/bash

echo "Creating ShotPlot Domain Architecture..."

MODULES=(
  Target
  Course
  RuleSet
  Match
  Baseline
  Recommendation
  Analytics
  Rifle
  Organization
)

SUBDIRS=(
  Contracts
  Data
  DTOs
  Models
  Repositories
  Services
  Tests
)

mkdir -p app/Domains

for module in "${MODULES[@]}"; do
    echo "Creating $module..."

    mkdir -p "app/Domains/$module"

    for dir in "${SUBDIRS[@]}"; do
        mkdir -p "app/Domains/$module/$dir"
    done

    cat > "app/Domains/$module/README.md" << EOF
# $module Module

## Purpose

Describe the responsibility of this module.

---

## Responsibilities

-

---

## Public Services

-

---

## Owned Data

-

---

## Dependencies

-

---

## Future Work

-

EOF

done

echo ""
echo "Done!"
echo ""
echo "Created:"
tree app/Domains
