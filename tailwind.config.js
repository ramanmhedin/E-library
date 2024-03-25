import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    darkMode: 'class', // Enable dark mode with the 'class' strategy.
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
