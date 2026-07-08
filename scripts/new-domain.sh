#!/bin/bash

DOMAIN="$1"
USES_DATA="${2:-yes}"
USES_MODELS="${3:-yes}"
USES_REPOSITORIES="${4:-yes}"

if [ -z "$DOMAIN" ]; then
    echo "Usage: ./scripts/new-domain.sh DomainName [uses_data=yes|no] [uses_models=yes|no] [uses_repositories=yes|no]"
    echo ""
    echo "Examples:"
    echo "  ./scripts/new-domain.sh RuleSet"
    echo "  ./scripts/new-domain.sh CourseResolver no no no"
    exit 1
fi

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_ROOT="$( cd "$SCRIPT_DIR/.." && pwd )"
cd "$PROJECT_ROOT" || exit 1

LOWER_DOMAIN="$(echo "$DOMAIN" | tr '[:upper:]' '[:lower:]')"
BASE="app/Domains/$DOMAIN"

echo "Creating $DOMAIN domain..."

mkdir -p "$BASE"/{Config,Contracts,DTOs,Services,Tests}

if [ "$USES_DATA" != "no" ]; then
    mkdir -p "$BASE/Data"
fi

if [ "$USES_MODELS" != "no" ]; then
    mkdir -p "$BASE/Models"
fi

if [ "$USES_REPOSITORIES" != "no" ]; then
    mkdir -p "$BASE/Repositories"
fi

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

INTERFACE_FILE="$BASE/Contracts/${DOMAIN}ServiceInterface.php"

if [ ! -f "$INTERFACE_FILE" ]; then
cat > "$INTERFACE_FILE" << EOF
<?php

namespace App\\Domains\\$DOMAIN\\Contracts;

interface ${DOMAIN}ServiceInterface
{
    public function all(): array;

    public function get(string \$id): ?array;

    public function exists(string \$id): bool;

    public function ids(): array;
}
EOF
fi

SERVICE_FILE="$BASE/Services/${DOMAIN}Service.php"

if [ ! -f "$SERVICE_FILE" ]; then
cat > "$SERVICE_FILE" << EOF
<?php

namespace App\\Domains\\$DOMAIN\\Services;

use App\\Domains\\$DOMAIN\\Contracts\\${DOMAIN}ServiceInterface;

class ${DOMAIN}Service implements ${DOMAIN}ServiceInterface
{
    protected array \$definitions;

    public function __construct()
    {
        \$this->definitions = require app_path(
            'Domains/$DOMAIN/Data/${LOWER_DOMAIN}_definitions.php'
        );
    }

    public function all(): array
    {
        return \$this->definitions;
    }

    public function get(string \$id): ?array
    {
        return \$this->definitions[\$id] ?? null;
    }

    public function exists(string \$id): bool
    {
        return isset(\$this->definitions[\$id]);
    }

    public function ids(): array
    {
        return array_keys(\$this->definitions);
    }
}
EOF
fi

if [ "$USES_DATA" != "no" ]; then
    DATA_FILE="$BASE/Data/${LOWER_DOMAIN}_definitions.php"

    if [ ! -f "$DATA_FILE" ]; then
cat > "$DATA_FILE" << EOF
<?php

return [
    //
];
EOF
    fi
fi

TEST_FILE="$BASE/Tests/${DOMAIN}ServiceTest.php"

if [ ! -f "$TEST_FILE" ]; then
cat > "$TEST_FILE" << EOF
<?php

namespace App\\Domains\\$DOMAIN\\Tests;

use Tests\\TestCase;
use App\\Domains\\$DOMAIN\\Contracts\\${DOMAIN}ServiceInterface;

class ${DOMAIN}ServiceTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        \$service = app(${DOMAIN}ServiceInterface::class);

        \$this->assertInstanceOf(
            ${DOMAIN}ServiceInterface::class,
            \$service
        );
    }
}
EOF
fi

echo ""
echo "=================================="
echo "Domain $DOMAIN created."
echo ""
echo "Remember to register in AppServiceProvider:"
echo ""
echo "use App\\Domains\\$DOMAIN\\Contracts\\${DOMAIN}ServiceInterface;"
echo "use App\\Domains\\$DOMAIN\\Services\\${DOMAIN}Service;"
echo ""
echo "\$this->app->singleton("
echo "    ${DOMAIN}ServiceInterface::class,"
echo "    ${DOMAIN}Service::class"
echo ");"
echo "=================================="
