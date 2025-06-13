document.addEventListener('DOMContentLoaded', function () {
    var mapDiv = document.getElementById('lmp-map');
    if (typeof LMP_LOCATIONS === 'undefined' || !mapDiv) return;
    if (!mapDiv.style.height) mapDiv.style.height = '500px';
    if (!mapDiv.style.width) mapDiv.style.width = '100%';
    var map = new google.maps.Map(mapDiv, {
        center: { lat: 51.5074, lng: -0.1278 }, // London
        zoom: 12
    });
    LMP_LOCATIONS.forEach(function (loc) {
        if (!loc.lat || !loc.lng) return;
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(loc.lat), lng: parseFloat(loc.lng) },
            map: map,
            title: loc.title
        });
        var infowindow = new google.maps.InfoWindow({
            content: '<h3>' + loc.title + '</h3>' + loc.description
        });
        marker.addListener('click', function () {
            infowindow.open(map, marker);
        });
    });
}); 