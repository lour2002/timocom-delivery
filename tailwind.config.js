module.exports = {
    purge: {
        enabled: true,
        content: ['./resources/views/**/*.blade.php','./public/*.html'],
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
        container: {
            center: true,
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active', 'checked', 'disabled'],
            outline: ['active'],
            opacity: ['disabled'],
            textColor: ['disabled']
        }
    },
    plugins: [],
}
