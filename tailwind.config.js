export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    safelist: [
        'dark:bg-gray-800',
        'dark:bg-gray-900',
        'dark:text-gray-300',
        'dark:text-gray-400',
        'dark:hover:text-gray-100',
        'dark:bg-gray-200',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
