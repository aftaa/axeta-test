let app = new Vue({
    el: '#app',
    data: {
        candidateId: null,
        candidate: {},
        spinner: false,
        nameIsOk: false,
        nameIsKo: false,
        placeIsOk: false,
        placeIsKo: false
    },
    methods: {
        fetch: (uri, method = 'GET', body = null) => {
            let options = {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };
            if (null !== body) {
                options.body = JSON.stringify(body)
            }
            return fetch(uri, options);
        },

        fetchCandidate: () => {
            app.fetch('/api/candidate/' + app.candidateId)
                .then(response => response.json())
                .then(user => app.candidate = user);

        },

        nameKeyUp: () => app.nameIsKo = !app.candidate.name.length,
        placeKeyUp: () => {
            app.placeIsKo = !app.candidate.place.length;
            let pcre = /[^ ,0-9a-zа-я\.]/i;
            app.placeIsKo = pcre.test(app.candidate.place);
        },

        storeName: () => {
            if (app.nameIsKo) return;
            app.spinner = true;
            app.fetch('/api/candidate/' + app.candidateId, 'PUT', {name: app.candidate.name})
                .then(() => {
                    app.spinner = false;
                    app.nameIsOk = true;
                    setTimeout(() => app.nameIsOk = false, 1000);
                });
        },

        storePlace: () => {
            if (app.placeIsKo) return;
            app.spinner = true;
            app.fetch('/api/candidate/' + app.candidateId, 'PATCH', {name: app.candidate.place})
                .then(() => {
                    app.spinner = false;
                    app.placeIsOk = true;
                    setTimeout(() => app.placeIsOk = false, 1000);
                });
        }
    }
});
