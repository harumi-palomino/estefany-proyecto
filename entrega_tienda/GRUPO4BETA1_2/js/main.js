const contenedor = document.getElementById('contenido');
const enlaces = document.querySelectorAll('.enlace-nav');

function marcarActivo(pagina) {
  enlaces.forEach(function (enlace) {
    if (enlace.dataset.pagina === pagina) {
      enlace.classList.add('activo');
    } else {
      enlace.classList.remove('activo');
    }
  });
}

function cargarPagina(pagina) {
  fetch('paginas/' + pagina + '.html')
    .then(function (respuesta) {
      if (!respuesta.ok) {
        throw new Error('No se pudo cargar la página ' + pagina);
      }
      return respuesta.text();
    })
    .then(function (html) {
      contenedor.innerHTML = html;

      var scriptViejo = contenedor.querySelector('script');
      if (scriptViejo) {
        var scriptNuevo = document.createElement('script');
        scriptNuevo.textContent = scriptViejo.textContent;
        scriptViejo.replaceWith(scriptNuevo);
      }

      marcarActivo(pagina);
    })
    .catch(function (error) {
      contenedor.innerHTML = '<p class="py-16 text-center text-carbon/60">' + error.message + '</p>';
    });
}

enlaces.forEach(function (enlace) {
  enlace.addEventListener('click', function (evento) {
    evento.preventDefault();
    cargarPagina(enlace.dataset.pagina);
  });
});

cargarPagina('inicio');
