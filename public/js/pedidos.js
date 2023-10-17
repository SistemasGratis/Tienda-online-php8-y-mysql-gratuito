let tblPendientes;
const myModal = new bootstrap.Modal(document.getElementById("modalEnvio"));
let lista = document.querySelector("#lista");
document.addEventListener("DOMContentLoaded", function () {
  tblPendientes = $("#tblPendientes").DataTable({
    ajax: {
      url: base_url + "profile/listarPedidos",
      dataSrc: "",
    },
    columns: [
      { data: "productos" },
      { data: "fecha" },
      { data: "transaccion" },
      { data: "total" },
      { data: "estado" },
    ],
    language,
    dom: "Bfrtip",
    order: [[1, "desc"]],
  });

  $("#tblPendientes tbody").on("dblclick", "tr", function () {
    var data = tblPendientes.row(this).data();
    verDireccion(data.id);
  });
});

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
