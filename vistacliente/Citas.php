<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    
    <!-- Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .step {
            display: none;
            margin-top: 20px;
        }
        .active {
            display: block;
        }
        #leafletMap {
            height: 200px;
            width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover {
            background: #0056b3;
        }
        select, input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <form id="citaForm">
        <div id="step1" class="step active">
            <h3>Seleccione una Sucursal</h3>
            <select id="sucursalSelect" required onchange="updateMap()">
                <option value="">Seleccione una sucursal</option>
                <option value="villa_union">Sucursal Villa Unión</option>
            </select>
            
            <div id="leafletMap"></div>
        </div>

        <div id="step2" class="step">
            <h3>Seleccione un Barbero</h3>
            <select id="barberoSelect" onchange="cargarServicios()">
                <option value="">Seleccione un barbero</option>
                <!-- Los barberos se cargarán dinámicamente -->
            </select>
        </div>

        <div id="step3" class="step">
            <h3>Seleccione el corte</h3>
            <select id="servicioSelect">
                <option value="">Seleccione un servicio</option>
            </select>
        </div>

        <div id="step4" class="step">
            <h3>Seleccione el Tipo de Pago</h3>
            <select id="pagoSelect">
                <option value="">Seleccione un tipo de pago</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
            </select>
        </div>

        <button type="submit">Finalizar</button>
    </form>
</div>

<script>
    let leafletMap;
    let leafletMarker;

    // Muestra el mapa y la sucursal seleccionada
    function updateMap() {
        let sucursal = document.getElementById("sucursalSelect").value;
        
        if (sucursal === "villa_union") {
            let lat = 27.2231;
            let lng = -100.6894;

            document.getElementById("leafletMap").style.display = "block";

            if (!leafletMap) {
                leafletMap = L.map('leafletMap').setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(leafletMap);

                leafletMarker = L.marker([lat, lng]).addTo(leafletMap)
                    .bindPopup("Sucursal Villa Unión, Coahuila")
                    .openPopup();
            } else {
                leafletMap.setView([lat, lng], 15);
                leafletMarker.setLatLng([lat, lng]);
            }

            cargarBarberos(); // Cargar barberos al seleccionar una sucursal
        } else {
            document.getElementById("leafletMap").style.display = "none";
        }
    }

    // Cargar barberos desde la base de datos o API
    function cargarBarberos() {
        const sucursal = document.getElementById("sucursalSelect").value;

        if (sucursal === "villa_union") {
            // Aquí simulamos la carga de barberos para la sucursal Villa Unión
            const barberos = [
                { id: 1, nombre: "Juan Pérez" },
                { id: 2, nombre: "Carlos González" }
            ];
            
            const select = document.getElementById("barberoSelect");
            select.innerHTML = '<option value="">Seleccione un barbero</option>'; 

            barberos.forEach(barbero => {
                let option = document.createElement("option");
                option.value = barbero.id;
                option.textContent = barbero.nombre;
                select.appendChild(option);
            });

            // Muestra la segunda sección
            document.getElementById("step2").classList.add("active");
        }
    }

    // Cargar los servicios disponibles para el barbero seleccionado
    function cargarServicios() {
        const barberoSelect = document.getElementById("barberoSelect");
        const servicioSelect = document.getElementById("servicioSelect");
        const barberoSeleccionado = barberoSelect.value;
        
        // Aquí puedes cargar los servicios desde la base de datos en función del barbero
        const serviciosPorBarbero = {
            "1": ["Corte clásico", "Afeitado tradicional", "Corte y barba"],
            "2": ["Corte moderno", "Diseño de barba", "Tinte para cabello"]
        };

        servicioSelect.innerHTML = '<option value="">Seleccione un servicio</option>';
        
        if (barberoSeleccionado && serviciosPorBarbero[barberoSeleccionado]) {
            serviciosPorBarbero[barberoSeleccionado].forEach(servicio => {
                let option = document.createElement("option");
                option.value = servicio.toLowerCase().replace(/\s+/g, '_');
                option.textContent = servicio;
                servicioSelect.appendChild(option);
            });

            // Muestra la tercera sección
            document.getElementById("step3").classList.add("active");
        }
    }

    // Manejo de formulario de cita
    document.getElementById('citaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        alert("Cita Agendada exitosamente");
        // Aquí podrías enviar los datos del formulario a un servidor
    });
</script>

</body>
</html>
