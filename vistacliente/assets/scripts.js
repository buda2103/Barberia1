document.addEventListener("DOMContentLoaded", function () {
    console.log("Página cargada correctamente");
});
//lista//

document.addEventListener("DOMContentLoaded", function () {
    fetch('../controlador/obtener_servicios.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Verifica en la consola que los datos llegan correctamente
            let select = document.getElementById('servicioSelect');

            if (!select) {
                console.error("Elemento select con id 'servicioSelect' no encontrado.");
                return;
            }

            data.forEach(servicio => {
                let option = document.createElement('option');
                option.value = servicio.id;
                option.textContent = `${servicio.nombre} - $${servicio.precio}`;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error obteniendo servicios:', error));
});
function iniciarMap(){
    var coord = {lat:-34.5956145 ,lng: -58.4431949};
    var map = new google.maps.Map(document.getElementById('map'),{
      zoom: 10,
      center: coord
    });
    var marker = new google.maps.Marker({
      position: coord,
      map: map
    });
}
