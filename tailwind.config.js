module.exports = {
    purge: {
        enabled: true,
        content: ['./resources/views/**/*.blade.php'],
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {
            backgroundColor: ['active', 'checked'],
            outline: ['active'],
            opacity: ['disabled']
        }
    },
    plugins: [],
}
