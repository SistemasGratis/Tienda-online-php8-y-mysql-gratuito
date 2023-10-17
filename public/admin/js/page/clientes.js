let tblClientes;

const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const btnNuevo = document.querySelector("#btnNuevo");

const apellido = document.querySelector("#apellido");
const nombre = document.querySelector("#nombre");
const correo = document.querySelector("#correo");
const direccion = document.querySelector("#direccion");
const id = document.querySelector("#id");

const errorApellido = document.querySelector("#errorApellido");
const errorNombre = document.querySelector("#errorNombre");
const errorTelefono = document.querySelector("#errorTelefono");
const errorDireccion = document.querySelector("#errorDireccion");

const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));

document.addEventListener("DOMContentLoaded", function () {
  //cargar datos con el plugin datatables
  tblClientes = $("#tblClientes").DataTable({
    ajax: {
      url: base_url + "clientes/listar",
      dataSrc: "",
    },
    columns: [
      { data: "item" },
      { data: "nombre" },
      { data: "apellido" },
      { data: "correo" },
      { data: "direccion" },
      { data: "acciones" },
    ],
    language,
    dom: "Bfrtip",
    buttons,
    responsive: true,
    order: [[0, "desc"]],
  });

  //limpiar campos
  nuevo.addEventListener("click", function () {
    document.querySelector("#id").value = "";
    titleModal.textContent = "NUEVO CLIENTE";
    btnAccion.textContent = "Registrar";
    frm.reset();
    myModal.show();
  });
  //registrar clientes
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (nombre.value == "" || apellido.value == "" || direccion.value == "") {
      alertas("TODO LOS CAMPOS CON * SON REQUERIDOS", 2);
    } else {
      const url = base_url + "clientes/registrar";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(this));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.type == "success") {
            tblClientes.ajax.reload();
            frm.reset();
            id.value = "";
            btnAccion.textContent = "Registrar";
            myModal.hide();
          }
          let type = res.type == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
});

function eliminarCliente(idCliente) {
  Swal.fire({
    title: "Aviso?",
    text: "Esta seguro de eliminar el registro!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "clientes/eliminar/" + idCliente;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.type == "success") {
            tblClientes.ajax.reload();
          }
          let type = res.type == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
}

function editarCliente(idCliente) {
  const url = base_url + "clientes/editar/" + idCliente;
  //hacer una instancia del objeto XMLHttpRequest
  const http = new XMLHttpRequest();
  //Abrir una Conexion - POST - GET
  http.open("GET", url, true);
  //Enviar Datos
  http.send();
  //verificar estados
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      id.value = res.id;
      nombre.value = res.nombre;
      apellido.value = res.apellido;
      correo.value = res.correo;
      direccion.value = res.direccion;
      btnAccion.textContent = "Actualizar";
      myModal.show();
    }
  };
}
