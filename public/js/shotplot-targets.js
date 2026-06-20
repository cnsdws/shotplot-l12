window.ShotPlotTargets = {
    "SR": {
        label: "SR - 200 Yard High Power",
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", radius: 250 },
            { score: "6", radius: 220 },
            { score: "7", radius: 190 },
            { score: "8", radius: 160 },
            { score: "9", radius: 120 },
            { score: "10", radius: 80 },
            { score: "X", radius: 35 }
        ]
    },

    "SR-1": {
        label: "SR-1 - 100 Yard Reduced",
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", radius: 250 },
            { score: "6", radius: 220 },
            { score: "7", radius: 190 },
            { score: "8", radius: 160 },
            { score: "9", radius: 120 },
            { score: "10", radius: 80 },
            { score: "X", radius: 35 }
        ]
    },

    "SR-42": {
        label: "SR-42 - 300 Yard Rapid Prone",
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", radius: 250 },
            { score: "6", radius: 220 },
            { score: "7", radius: 190 },
            { score: "8", radius: 155 },
            { score: "9", radius: 115 },
            { score: "10", radius: 75 },
            { score: "X", radius: 32 }
        ]
    },

    "SR-3": {
        label: "SR-3 - 200 Yard Reduced 300",
        blackRings: [9, 10, "X"],
        rings: [
            { score: "5", radius: 250 },
            { score: "6", radius: 220 },
            { score: "7", radius: 190 },
            { score: "8", radius: 155 },
            { score: "9", radius: 115 },
            { score: "10", radius: 75 },
            { score: "X", radius: 32 }
        ]
    },

    "MR-52": {
        label: "MR-52 - 600 Yard Prone",
        blackRings: [8, 9, 10, "X"],
        rings: [
            { score: "6", radius: 250 },
            { score: "7", radius: 215 },
            { score: "8", radius: 175 },
            { score: "9", radius: 130 },
            { score: "10", radius: 85 },
            { score: "X", radius: 38 }
        ]
    },

    "MR-1": {
        label: "MR-1 - Reduced Mid-Range",
        blackRings: [7, 8, 9, 10, "X"],
        rings: [
            { score: "6", radius: 250 },
            { score: "7", radius: 215 },
            { score: "8", radius: 175 },
            { score: "9", radius: 130 },
            { score: "10", radius: 85 },
            { score: "X", radius: 38 }
        ]
    },

    "MR-31": {
        label: "MR-31 - 100 Yard Reduced 600",
        blackRings: [8, 9, 10, "X"],
        rings: [
            { score: "6", radius: 250 },
            { score: "7", radius: 215 },
            { score: "8", radius: 175 },
            { score: "9", radius: 130 },
            { score: "10", radius: 85 },
            { score: "X", radius: 38 }
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
