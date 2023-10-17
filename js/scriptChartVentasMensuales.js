/*
Encierro todo en una función asíncrona para poder usar async y await cómodamente
https://parzibyte.me/blog
*/
(async () => {
    // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
    const respuestaRaw = await fetch("./ajax/getVentasMensuales.php");
    // Decodificar como JSON
    const respuesta = await respuestaRaw.json();
    // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
    // Obtener una referencia al elemento canvas del DOM
    const $graficaVentasMes = document.querySelector("#graficaVentasMes");
    const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datosVentas = {
        label: "Ingresos por mes",
        // Pasar los datos igualmente desde PHP
        data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
        borderWidth: 1, // Ancho del borde
    };
    new Chart($graficaVentasMes, {
        type: 'line', // Tipo de gráfica
        data: {
            labels: etiquetas,
            datasets: [
                datosVentas,
                // Aquí más datos...
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
        }
    });
})();
