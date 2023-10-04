let app = new Vue({
    el: '#app',
    data: {
        name: 'John Smith',
        place: 'Portland, Oregon, USA',
        lang: 'English',
        lang_pic: '/svg/en.svg',

        experience: [{
            name: 'PHP',
            experience: '6 year'
        }, {
            name: 'Ruby',
            experience: '2 year'
        }, {
            name: 'Java Script',
            experience: '4.5 years'
        }],

        portfolio: [{
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
        }]
    },
    methods: {

    }
});