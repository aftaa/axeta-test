ymaps.ready(init);
function init() {
    if (!window.myMap) {
        var myMap = window.myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 7,
            controls: []
        });
    }
    ymaps.geocode(app.candidate.place, {
        results: 1
    }).then(function (res) {
        let firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates(),
            bounds = firstGeoObject.properties.get('boundedBy');
        window.myMap.setCenter(coords);
        window.myMap.setZoom(9);
    });
}
