Vue.config.productionTip = false;

let app = new Vue({
    el: '#app',
    data: {
        user: {
        }
    },
    methods: {
        fetch: () => {
            fetch('/api/candidate/' + candidateId, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(user => {
                    app.user = user;
                    $('#app').fadeIn('slow');
                    stopSpinner();
                });
        }
    }
});

app.fetch();
