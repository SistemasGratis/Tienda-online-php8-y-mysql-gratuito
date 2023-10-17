let tblPendientes;
const myModal = new bootstrap.Modal(document.getElementById("modalEnvio"));
document.addEventListener("DOMContentLoaded", function () {
  tblPendientes = $("#tblPendientes").DataTable({
    ajax: {
      url: base_url + "pedidos/listarPedidos",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "productos" },
      { data: "fecha" },
      { data: "transaccion" },
      { data: "total" },
      { data: "estado" },
      { data: "accion" }
    ],
    language,
    dom: "Bfrtip",
    buttons,
    order: [[0, "desc"]],
  });

  $("#tblPendientes tbody").on("dblclick", "tr", function () {
    var data = tblPendientes.row(this).data();
    if (data.proceso == 1) {
      cambiarProceso(data.id);
    }
  });
});

function cambiarProceso(idPedido) {
  Swal.fire({
    title: "Aviso?",
    text: "Esta seguro de cambiar el estado!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "pedidos/update/" + idPedido;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.icono == "success") {
            tblPendientes.ajax.reload();
          }
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
}

function verDireccion(idPedido) {
  const url = base_url + "profile/verPedido/" + idPedido;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      lista.innerHTML = `<ul class="list-group">
            <li class="list-group-item">Cliente => ${res.nombre + ' ' + res.apellido}</li>
            <li class="list-group-item">Dirección => ${res.direccion}</li>
            <li class="list-group-item">Teléfono => ${res.telefono}</li>
            <li class="list-group-item">Ciudad => ${res.ciudad}</li>
            <li class="list-group-item">Pais => ${res.pais}</li>
            <li class="list-group-item">Codigo posta => ${res.cod}</li>
          </ul>`;
      myModal.show();
    }
  };
}
