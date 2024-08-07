import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./resources/views/**/*.blade.php",
        ...'./vendor/jaocero/activity-timeline/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            width: {
                test: "64rem",
            },
        },
        color: {
            kl: "#295CA9",
        },
    },
};
