# ShotPlot Domain Model

## Product Vision

ShotPlot is a personal marksmanship instructor and digital data book. It records shots, match conditions, rifle settings, and shooter history, then helps the shooter make better sight decisions.

## Core Concepts

### User
An individual ShotPlot account.

### Organization
A group that owns or shares courses and matches.

Types:
- Personal
- Range
- Gun Club
- Team
- Military Unit
- Training Company
- Governing Body

### Organization Role
Defines what a user can do inside an organization.

Roles:
- Owner
- Administrator
- Match Director
- Coach / PMI
- Range Officer
- Shooter
- Guest

### Rule Set
Defines the rules of a discipline.

Examples:
- NRA High Power
- CMP Service Rifle
- USMC KD
- NRA Long Range
- F-Class
- PRS

### Course Template
A reusable course of fire.

Examples:
- National Match Course
- EIC Match
- USMC Table 1
- July 4 Club Match

### Course Stage
One stage inside a course template.

Examples:
- 200 Slow
- 200 Rapid
- 300 Rapid
- 600 Slow

### Range Setup
Defines whether the course is fired at full distance, reduced distance, or custom distances.

Examples:
- Full distance
- 100-yard reduced
- 200-yard reduced
- Mixed / custom

### Match
A scheduled instance of a course.

### Firestring
A shooter’s actual record for one course stage.

### Shot
One fired round, including score and plotted location.

### Rifle
A shooter’s weapon system.

### Zero
A rifle’s permanent baseline sight setting.

### Sight Setting
The actual elevation and windage used for a firestring.

### Baseline
ShotPlot’s recommended starting setting for a rifle, ammo, distance, and course context.

### Condition
Environmental data that applies to a string.

Examples:
- Wind
- Light
- Mirage
- Temperature
- Humidity
- Pressure

### Event
Something that happens during a string.

Examples:
- Alibi
- Refire
- Crossfire
- Saved round
- Extra shot
- Equipment failure
- Wind shift
- Range delay

### Recommendation
A ShotPlot-generated suggested action.

Examples:
- Up 2 clicks
- Left 1 click
- Do not adjust yet
- Fire another group
- Return to baseline

## Ownership Rules

Users own:
- Rifles
- Personal zeros
- Personal shooting history
- Personal course copies

Organizations own:
- Shared course templates
- Organization matches
- Member access
- Range-specific course variants

ShotPlot owns:
- Official rule sets
- Official baseline templates
- Standard target definitions
- Built-in course templates

## Sharing Rules

Course templates may be:
- Private
- Organization-shared
- Public
- Official ShotPlot content

Copied courses should retain a parent reference so lineage is preserved.

Example:
Castle Rock Holiday Match → copied by Dennis → modified for 100-yard reduced range.

## Important Design Principles

1. Rifle zero is permanent baseline data.
2. Match sight settings are temporary.
3. Course distance and actual distance are different concepts.
4. Targets are derived from course, distance, and range setup.
5. Firestrings should eventually be generated from course stages.
6. ShotPlot recommendations should use clicks, not MOA, when advising the shooter.
7. The system should support yards and meters.
8. The system should support full-distance, reduced-distance, and mixed-distance matches.
