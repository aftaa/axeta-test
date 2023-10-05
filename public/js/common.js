let app = new Vue({
    el: '#app',
    data: {
        user: {
            photo: '/userpics/1.png',
            name: 'John Smith',
            place:
                'Portland, Oregon, USA',
            lang:
                'English',
            lang_pic:
                '/svg/en.svg',

            experience:
                [{
                    name: 'PHP',
                    experience: '6 year'
                }, {
                    name: 'Ruby',
                    experience: '2 year'
                }, {
                    name: 'Java Script',
                    experience: '4.5 years'
                }],

            portfolio:
                [{
                    name: 'Bootstrap 4 Material Design (Sample Link)',
                    href: '#'
                }, {
                    name: 'Modern JavaScript stack',
                    href: '#'
                }, {
                    name: 'Datepicker for twitter bootstrap',
                    href: '#'
                }, {
                    name: 'Fast and reliable Bootstrap widgets in Angular',
                    href: '#'
                }],
            availability: 'Full-time',
            environment: 'GitHub, Mac OSX',
            amaizing: 'The only true wisdom is in knowing you know nothing...',
            expectation: 'There is only one good, knowledge, and one evil, ignorance.'
        }
    },
    methods: {}
});