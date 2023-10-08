let app = new Vue({
    el: '#app',
    data: {
        candidateId: {},
        candidate: {
            portfolios: [],
            skills: [
                {experience: 0}
            ],
        },
        spinner: false,

        nameIsOk: false,
        nameIsKo: false,

        placeIsOk: false,
        placeIsKo: false,

        newSkill: false
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

        sortSkills: () => {
            app.candidate.skills.sort((a, b) => {
                a = Number(a.experience), b = Number(b.experience);
                return b - a;
            });
        },

        fetchCandidate: () => {
            return app.fetch('/api/candidate/' + app.candidateId)
                .then(response => response.json())
                .then(candidate => {
                    app.candidate = candidate;
                    app.sortSkills();
                    init();
                    document.getElementById('app').style.display = 'block';
                    document.getElementById('loading').style.display = 'none';
                })
                .catch(e => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('not-found').style.display = 'block';
                });
        },

        nameKeyUp: () => app.nameIsKo = !app.candidate.name.length,

        placeKeyUp: () => {
            app.placeIsKo = !app.candidate.place.length;
            if (app.placeIsKo) return;
            let pcre = /[^- ,0-9a-zа-я]/i;
            app.placeIsKo = pcre.test(app.candidate.place);
        },

        storeName: event => {
            if (app.nameIsKo) return;
            bootstrap.Tooltip.getInstance('#candidate-name').hide();
            app.spinner = true;
            app.fetch('/api/candidate/name/' + app.candidateId, 'PATCH', {name: app.candidate.name})
                .then(() => {
                    app.spinner = false;
                    app.nameIsOk = true;
                    setTimeout(() => app.nameIsOk = false, 1500);
                });
        },

        storePlace: () => {
            if (app.placeIsKo) return;
            bootstrap.Tooltip.getInstance('#candidate-place').hide();
            app.spinner = true;
            app.fetch('/api/candidate/place/' + app.candidateId, 'PATCH', {place: app.candidate.place})
                .then(() => {
                    app.spinner = false;
                    app.placeIsOk = true;
                    init();
                    setTimeout(() => app.placeIsOk = false, 1500);
                });
        },

        addSkill: event => {
            let skillName = event.target.value;
            if (!skillName.length) return;
            app.spinner = true;
            app.fetch('/api/skill', 'POST', {
                candidateId: app.candidateId,
                name: skillName
            })
                .then(() => {
                    app.newSkill = false;
                    app.fetchCandidate()
                        .then(() => app.spinner = false);
                })
        },

        editSkill: event => {
            event.target.style.display = 'none';
            event.target.nextElementSibling.style.display = 'block';
        },
        
        escapeSkill: event => {
            event.target.style.display = 'none';
            event.target.previousElementSibling.style.display = 'block';
        },

        saveSkill: event => {
            let id = event.target.dataset.id;
            let value = event.target.value;
            app.spinner = true;
            if (!value.length && confirm('Confirm delete the skill')) {
                app.fetch('/api/skill/' + id, 'DELETE')
                    .then(() => {
                        event.target.style.display = 'none';
                        event.target.previousElementSibling.style.display = 'block';
                        app.fetchCandidate();
                        app.spinner = false;
                    });
            } else {
                app.fetch('/api/skill/name/' + id, 'PATCH', {name: value})
                    .then(() => {
                        event.target.previousElementSibling.innerHTML = value;
                        event.target.previousElementSibling.style.display = 'block';
                        event.target.style.display = 'none';
                        app.fetchCandidate();
                        app.spinner = false;
                    });
            }
        },

        expEdit: event => {
            event.target.style.display = 'none';
            let input = event.target.nextElementSibling;
            input.style.display = 'inline';
            input.focus();
            input.select();
        },

        expEsc: event => {
            event.target.style.display = 'none';
            event.target.previousElementSibling.style.display = 'inline';
        },

        expSave: event => {
            app.spinner = true;
            let id = event.target.dataset.id;
            let value = event.target.value;
            event.target.previousElementSibling.innerHTML = value;
            app.fetch('/api/skill/experience/' + id, 'PATCH', {experience: value})
                .then(() => {
                    event.target.previousElementSibling.style.display = 'inline';
                    event.target.style.display = 'none';
                    app.fetchCandidate();
                    app.spinner = false;
                })
        }
    }
});
