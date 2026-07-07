#!/bin/bash

DOMAIN="$1"

if [ -z "$DOMAIN" ]; then
    echo "Usage: ./new-domain.sh DomainName"
    exit 1
fi

BASE="app/Domains/$DOMAIN"

echo "Creating $DOMAIN domain..."

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_ROOT="$( cd "$SCRIPT_DIR/.." && pwd )"
cd "$PROJECT_ROOT"

mkdir -p "$BASE"/{Config,Contracts,Data,DTOs,Models,Repositories,Services,Tests}

if [ ! -f "$BASE/README.md" ]; then
cat > "$BASE/README.md" << EOF
# $DOMAIN Domain

## Purpose

Describe the responsibility of this domain.

## Responsibilities

-

## Does NOT own

-

## Public Services

-

## Owned Data

-

## Dependencies

-

## Future Work

-
EOF
fi

echo "Done: $BASE"

