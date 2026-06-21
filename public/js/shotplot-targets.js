window.ShotPlotTargets = {
    "SR": {
        label: "SR - 200 Yard High Power",
        distanceYards: 200,
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 37.00 },
            { score: "6", diameterInches: 31.00 },
            { score: "7", diameterInches: 25.00 },
            { score: "8", diameterInches: 19.00 },
            { score: "9", diameterInches: 13.00 },
            { score: "10", diameterInches: 7.00 },
            { score: "X", diameterInches: 3.00 }
        ]
    },

    "SR-1": {
        label: "SR-1 - 100 Yard Reduced 200",
        distanceYards: 100,
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 18.35 },
            { score: "6", diameterInches: 15.35 },
            { score: "7", diameterInches: 12.35 },
            { score: "8", diameterInches: 9.35 },
            { score: "9", diameterInches: 6.35 },
            { score: "10", diameterInches: 3.35 },
            { score: "X", diameterInches: 1.35 }
        ]
    },

    "SR-42": {
        label: "SR-42 - 200 Yard Reduced 300",
        distanceYards: 200,
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 24.56 },
            { score: "6", diameterInches: 20.56 },
            { score: "7", diameterInches: 16.56 },
            { score: "8", diameterInches: 12.56 },
            { score: "9", diameterInches: 8.56 },
            { score: "10", diameterInches: 4.56 },
            { score: "X", diameterInches: 1.90 }
        ]
    },

    "SR-3": {
        label: "SR-3 - 300 Yard Rapid Prone",
        distanceYards: 300,
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 36.84 },
            { score: "6", diameterInches: 30.84 },
            { score: "7", diameterInches: 24.84 },
            { score: "8", diameterInches: 18.84 },
            { score: "9", diameterInches: 12.84 },
            { score: "10", diameterInches: 6.84 },
            { score: "X", diameterInches: 2.85 }
        ]
    },

    "MR-52": {
        label: "MR-52 - 200 Yard Reduced 600",
        distanceYards: 200,
        blackRings: [7, 8, 9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 19.79 },
            { score: "6", diameterInches: 15.79 },
            { score: "7", diameterInches: 11.79 },
            { score: "8", diameterInches: 7.79 },
            { score: "9", diameterInches: 5.79 },
            { score: "10", diameterInches: 3.79 },
            { score: "X", diameterInches: 1.79 }
        ]
    },

    "MR-1": {
        label: "MR-1 - 600 Yard Mid-Range",
        distanceYards: 600,
        blackRings: [7, 8, 9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 60.00 },
            { score: "6", diameterInches: 48.00 },
            { score: "7", diameterInches: 36.00 },
            { score: "8", diameterInches: 24.00 },
            { score: "9", diameterInches: 18.00 },
            { score: "10", diameterInches: 12.00 },
            { score: "X", diameterInches: 6.00 }
        ]
    },

    "MR-31": {
        label: "MR-31 - 100 Yard Reduced 600",
        distanceYards: 100,
        blackRings: [7, 8, 9, 10, "X"],
        rings: [
            { score: "5", diameterInches: 9.75 },
            { score: "6", diameterInches: 7.75 },
            { score: "7", diameterInches: 5.75 },
            { score: "8", diameterInches: 3.75 },
            { score: "9", diameterInches: 2.75 },
            { score: "10", diameterInches: 1.75 },
            { score: "X", diameterInches: 0.75 }
        ]
    }
};

window.ShotPlotTargetForDistance = function (distance) {
    switch (distance) {
        case "200 Yard Slow Fire":
        case "200 Yard Rapid Fire":
            return "SR";

        case "300 Yard Rapid Fire":
            return "SR-42";

        case "600 Yard Slow Fire":
            return "MR-52";

        default:
            return "SR";
    }
};

window.ShotPlotRingRadiusPx = function (target, ring, maxRadius) {
    const outerDiameter = target.rings[0].diameterInches;
    const scale = maxRadius / (outerDiameter / 2);
    return (ring.diameterInches / 2) * scale;
};
