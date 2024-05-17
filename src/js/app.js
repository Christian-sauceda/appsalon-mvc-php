let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", () => {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); //Mostrar la seccion actual
  tabs(); //Cambiar de pestaña
  botonesPaginador(); //Agrega o quita botones del paginador
  paginaSiguiente(); //Comprueba si hay siguiente pagina
  paginaAnterior(); //Comprueba si hay pagina anterior
  consultarAPI(); //Consultar API
  idCliente(); // almacenar id del cliente en el objeto
  nombreCliente(); //Almacenar nombre del cliente en el objeto
  selecionarFecha(); //Almacenar fecha en el objeto
  selecionarHora(); //Almacenar hora en el objeto
  mostrarResumen(); //Muestra el resumen de la cita
}

function mostrarSeccion() {
  //Ocultar seccion anterior
  const seccionAnterior = document.querySelector(".mostrar");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }
  //seleccionar la seccion con el paso
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");
  //quitar el resaltado del paso anterior
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }
  //resaltar el paso actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);
      mostrarSeccion();
      botonesPaginador();
      paginaAnterior();
      paginaSiguiente();
    });
  });
}

function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    //ocultar boton siguiente y mostrar boton anterior
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
}

//Comprueba si hay siguiente pagina
function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", () => {
    if (paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
    mostrarSeccion();
  });
}

//Comprueba si hay pagina anterior
function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    if (paso <= pasoInicial) return;
    paso--;
    botonesPaginador();
    mostrarSeccion();
  });
}

async function consultarAPI() {
  try {
    const url = "/api/servicios";
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  //iterar sobre los servicios
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;
    //scripting nombre
    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;
    //scripting precio
    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$${precio}`;
    //div contenedor
    const divServicio = document.createElement("DIV");
    divServicio.classList.add("servicio");
    divServicio.dataset.idServicio = id;
    divServicio.onclick = function () {
      seleccionarServicio(servicio);
    };
    //seleccionar el div
    divServicio.appendChild(nombreServicio);
    divServicio.appendChild(precioServicio);
    //inyectar en el html
    document.querySelector("#servicios").appendChild(divServicio);
  });
}

function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;
  //identificar al elemento que se le dio click
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
  //verificar si el servicio ya esta en el arreglo
  if (servicios.some((agregado) => agregado.id === id)) {
    //eliminar el servicio del arreglo
    cita.servicios = servicios.filter((servicio) => servicio.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    //agregar el servicio al arreglo
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }
}

function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value;
}

function idCliente() {
  cita.id = document.querySelector("#id").value;
}

function selecionarFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", function (e) {
    //no poder seleccionar dias sabados y domingos
    const dia = new Date(this.value).getUTCDay();
    if ([0, 6].includes(dia)) {
      e.target.value = "";
      mostrarAlerta(
        "Selecciona un día entre lunes y viernes.",
        "error",
        ".formulario"
      );
    } else {
      cita.fecha = this.value;
    }
  });
}

function selecionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", function (e) {
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];
    if (hora < 10 || hora > 18) {
      e.target.value = "";
      mostrarAlerta(
        "Selecciona una hora entre las 10:00 AM y las 6:00 PM.",
        "error",
        ".formulario"
      );
      setTimeout(() => {
        inputHora.value = "";
      }, 3000);
    } else {
      cita.hora = horaCita;
    }
  });
}

//Muestra alerta en pantalla
function mostrarAlerta(mensaje, tipo, elemento, desaparecer = true) {
  //si hay una alerta previa no crear otra
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }
  //crear la alerta
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);
  //insertar en el html
  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);
  //eliminar la alerta despues de 3 segundos
  if (desaparecer) {
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  //limpiar el contenido de resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }
  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Faltan datos por completar",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  //mostrar el resumen
  const { nombre, fecha, hora, servicios } = cita;

  //heading de servicios
  const headingServicios = document.createElement("H3");
  headingServicios.textContent = "Resumen de Servicios";
  resumen.appendChild(headingServicios);
  //iterar sobre los servicios
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");
    //nombre del servicio
    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;
    //precio del servicio
    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;
    //agregar texto y precio al div
    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);
    //agregar el div al resumen
    resumen.appendChild(contenedorServicio);
  });

  //heading de servicios
  const headingCita = document.createElement("H3");
  headingCita.textContent = "Resumen de Cita";
  resumen.appendChild(headingCita);
  //nombre del cliente
  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
  //formatear la fecha en español
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 1;
  const year = fechaObj.getFullYear();
  const fechaUTC = new Date(year, mes, dia);
  const fechaFormateada = fechaUTC.toLocaleDateString("es-HN", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });
  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
  //hora de la cita
  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

  //boton para confirmar la cita
  const botonReservar = document.createElement("BUTTON");
  botonReservar.classList.add("boton");
  botonReservar.textContent = "Resevar Cita";
  botonReservar.onclick = reservarCita;

  //agregar al resumen
  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);
  resumen.appendChild(botonReservar);
}

function toggleCerrarSesion() {
  var enlaceCerrarSesion = document.getElementById('enlaceCerrarSesion');
  enlaceCerrarSesion.style.display = (enlaceCerrarSesion.style.display === 'none') ? 'block' : 'none';
}

async function reservarCita() {
  const { id, fecha, hora, servicios } = cita;
  const serviciosID = servicios.map((servicio) => servicio.id);

  const datos = new FormData();
  datos.append("usuarioId", id);
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("servicios", serviciosID);

  try {
    //peticion hacia el api
    const url = "/api/cita";
    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });
    const resultado = await respuesta.json();
    if (resultado.resultado) {
      Swal.fire({
        icon: "success",
        title: "Cita Reservada",
        text: "Tu Cita ha sido reservada Correctamente!",
        button: "OK",
      }).then(() => {
        setTimeout(() => {
          window.location.reload();
        }, 3000);
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Hubo un error al reservar la cita, intenta de nuevo.",
    });
  }
}
