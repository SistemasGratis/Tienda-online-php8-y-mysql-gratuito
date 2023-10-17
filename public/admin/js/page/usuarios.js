let tblUsuarios;

const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const btnNuevo = document.querySelector("#btnNuevo");

const apellido = document.querySelector("#apellido");
const nombre = document.querySelector("#nombre");
const clave = document.querySelector("#clave");
const correo = document.querySelector("#correo");
const direccion = document.querySelector("#direccion");
const id = document.querySelector("#id");

const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));

document.addEventListener("DOMContentLoaded", function () {
  //cargar datos con el plugin datatables
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "item" },
      { data: "nombre" },
      { data: "apellido" },
      { data: "correo" },
      { data: "direccion" },
      { data: "accion" },
    ],
    language,
    dom: "Bfrtip",
    buttons,
    responsive: true,
    order: [[0, "desc"]],
  });

  //limpiar campos
  nuevo.addEventListener("click", function () {
    id.value = "";
    titleModal.textContent = "NUEVO USUARIO";
    btnAccion.textContent = "Registrar";
    clave.removeAttribute("readonly");
    frm.reset();
    myModal.show();
  });
  //registrar usuarios
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      nombre.value == "" ||
      apellido.value == "" ||
      clave.value == "" ||
      correo.value == "" ||
      direccion.value == ""
    ) {
      alertas("Todo los campos son requeridos", 2);
    } else {
      const url = base_url + "usuarios/registrar";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(this));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.icono == "success") {
            tblUsuarios.ajax.reload();
            frm.reset();
            id.value = "";
            btnAccion.textContent = "Registrar";
            myModal.hide();
          }
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
});

function eliminarUser(idUsuario) {
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
      const url = base_url + "usuarios/delete/" + idUsuario;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.icono == "success") {
            tblUsuarios.ajax.reload();
          }
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
}

function editUser(idUsuario) {
  const url = base_url + "usuarios/editar/" + idUsuario;
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
      clave.value = "00000000000";
      clave.setAttribute("readonly", "readonly");
      correo.value = res.correo;
      direccion.value = res.direccion;
      btnAccion.textContent = "Actualizar";
      myModal.show();
    }
  };
}
