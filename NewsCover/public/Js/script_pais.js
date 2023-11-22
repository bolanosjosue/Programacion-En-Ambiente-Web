document.addEventListener("DOMContentLoaded", function() {
    // Obtener la lista de países de la API RestCountries
    fetch("https://restcountries.com/v3.1/all")
        .then(response => response.json())
        .then(data => {
            // Ordenar los países alfabéticamente
            const sortedCountries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));

            // Obtener el elemento select del formulario
            const countrySelect = document.getElementById("country");

            // Iterar sobre los datos de los países ordenados y agregar opciones al select
            sortedCountries.forEach(country => {
                const option = document.createElement("option");
                option.value = country.name.common; // Puedes ajustar el valor según tus necesidades
                option.text = country.name.common;
                countrySelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error al obtener la lista de países:", error));
});