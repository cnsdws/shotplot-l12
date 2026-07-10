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


Architectural Layers
1. Knowledge

The Knowledge layer contains stable shooting knowledge and authoritative definitions.

Current domains:

RuleSet
Course
Stage
Position
Target

Current typed knowledge objects:

StageDefinition
PositionDefinition
TargetDefinition

Future knowledge domains may include:

CourseDefinition
RuleSetDefinition
TimeLimitDefinition
CommandDefinition
ScoringDefinition
TargetGeometry
WindModel
BallisticReference
CoachingDoctrine
DrillDefinition

Knowledge objects should be immutable and independent of Laravel persistence.

2. Planning

The Planning layer converts reference knowledge into executable plans.

Current components:

CoursePlanner
CoursePlan
StagePlan
FirestringTemplate

Future planners may include:

MatchPlanner
PracticePlanner
ZeroPlanner
WindPlanner
BallisticPlanner
TrainingPlanner

Planning should not persist application records directly.

3. Execution

The Execution layer turns plans into runtime activity.

Current components:

MatchFactory
FirestringTemplateService
Match creation workflow

Future execution concepts may include:

FiringSession
StageExecution
ShotRecording
AdjustmentTracking
CoachObservation
DrillSession

Execution services may coordinate persistence but should not contain rule-set knowledge.

4. Persistence

Persistence stores runtime and historical information.

Current models:

ShootingMatch
Firestring
Shot-related legacy columns
FirestringAdjustment
Rifle
BallisticProfile

Laravel Eloquent models are persistence models, not authoritative knowledge objects.

The current Firestring schema is a legacy compatibility boundary and will be replaced incrementally.

5. Analysis

The Analysis layer explains performance.

Future capabilities:

Group size and center
Score trends
Position-specific performance
Called-shot versus actual-impact comparison
Wind decision evaluation
Sight-adjustment evaluation
Consistency analysis
Error-pattern detection
Match and training summaries

Analysis should consume structured recorded data rather than query presentation-layer assumptions.

6. Coaching

The Coaching layer converts analysis into instruction.

Future capabilities:

Explain likely causes
Recommend drills
Identify priority weaknesses
Reinforce marksmanship fundamentals
Track improvement
Provide coach and mentor notes
Generate structured training plans

Recommendations must be explainable and traceable to recorded evidence and doctrine.

7. Presentation and Integration

Presentation includes:

Web UI
Tablet firing-line UI
Printable scorecards
PDFs
APIs
Future mobile clients
AI interfaces

Controllers remain thin and coordinate application services.

Current Match Creation Workflow
PositionsController::handleCreate()
        ↓
DB::transaction()
        ↓
ShootingMatch::create()
        ↓
MatchFactoryService::generateFirestrings()
        ↓
CoursePlannerService::buildPlan()
        ↓
CoursePlan
        ↓
StagePlan[]
        ↓
FirestringTemplateService
        ↓
FirestringTemplate
        ↓
Firestring persistence
Domain Relationships
RuleSet
    └── Course
          └── Stage
                ├── Position
                ├── Target
                ├── Distance
                ├── Fire Type
                └── Shot Count

Future relationships:

Stage
    ├── Time Limit
    ├── Commands
    ├── Scoring Rules
    ├── Equipment Rules
    └── Coaching Doctrine
Architectural Principles
Controllers stay thin.
Business logic belongs in domain services.
Reference knowledge is immutable.
Planning produces runtime plans.
Execution persists runtime activity.
Persistence models do not define shooting rules.
Domain relationships should be explicit rather than inferred from names.
Typed definition objects are preferred over associative arrays.
Dependencies are injected through interfaces.
New architecture replaces legacy paths rather than running in parallel indefinitely.
Recommendations must be explainable.
Tests protect business behavior, not implementation details.
Current Technical Debt
Firestring schema

The firestrings table still contains:

Stage name stored in distance
Shot values and coordinates embedded as repeated columns
No persisted shot_count
String columns for numeric values
Legacy environmental fields mixed with scoring data
Firestring model

Firestring::getShotCountAttribute() still infers shot count from the legacy stage name.

The authoritative shot count should come from StageDefinition and eventually be persisted explicitly.

Untyped knowledge

These domains still return arrays:

Course
RuleSet

They should eventually return typed immutable objects.

Controller responsibilities

PositionsController still contains multiple responsibilities and should be split into focused controllers.

Legacy routing

Several routes use legacy action-style URLs rather than resource-oriented named routes.

Recommended Refactoring Sequence
Phase 3A — Complete the typed knowledge layer
CourseDefinition
RuleSetDefinition
Typed CoursePlan
Remove remaining knowledge arrays
Phase 3B — Firestring persistence redesign
Add explicit stage identity
Add numeric distance
Add shot count
Introduce normalized Shot records
Migrate legacy shot columns
Preserve compatibility during transition
Phase 3C — Digital range book
Shot plotting
Called-shot recording
Conditions
Sight settings
Adjustments
Range notes
Printable data-book pages
Phase 3D — Digital PMI
Performance analysis
Diagnostic rules
Coaching explanations
Drill recommendations
Training plans
Mentor review workflow
AI-assisted coaching
Source Material

The knowledge engine may draw from authoritative and instructional sources, including:

NRA rule books
CMP rule books
Palma and F-Class rules
Marine Corps rifle marksmanship doctrine
Range-book references
Ballistic references
User-entered rifle, ammunition, and zero data

Source knowledge should be converted into structured definitions rather than embedded in controllers or database models.

Design Test

A new feature belongs in ShotPlot when it helps the shooter, coach, or mentor:

understand performance,
improve decision-making,
reinforce correct fundamentals,
plan effective practice,
or execute a course of fire accurately.

ShotPlot should not merely store shooting data.

It should turn shooting data into instruction.
