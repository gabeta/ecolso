
const resolveRoute = function(name, params = {}) {
    const page = JSON.parse(document.getElementById('app').dataset.page)
    const props = page.props

    return route('app.'+name, Object.assign({'team': props.current_team, 'year': props.current_year.slug}, params))
}

export const appRoute = {
    install: (v, options) => {
        const r = (name, params) => resolveRoute(name, params);

        console.log('okey');

        v.mixin({
            methods: {
                appRoute: r,
            },
        });

        if (parseInt(v.version) > 2) {
            v.provide('appRoute', r);
        }
    },
};
