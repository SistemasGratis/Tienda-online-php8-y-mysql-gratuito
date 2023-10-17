let tblHistorial;
document.addEventListener("DOMContentLoaded", function () {
  tblHistorial = $("#tblHistorial").DataTable({
    ajax: {
      url: base_url + "ventas/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "productos" },
      { data: "fecha" },
      { data: "nombre" },
      { data: "total" },
      { data: "estado" },
      { data: "accion" },
    ],
    selected: true,
    language,
    dom: "Bfrtip",
    buttons,
    order: [[0, "desc"]],
  });

  $("#tblHistorial tbody").on("dblclick", "tr", function () {
    var data = tblHistorial.row(this).data();
    if (data.status == 1) {
      anularVenta(data.id);
    }
  });
});

function anularVenta(idVenta) {
  Swal.fire({
    title: "Advertencia",
    text: "Esta seguro de cancelar la venta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Anular!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "ventas/anular/" + idVenta;
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
          let type = res.type == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
          if (res.type == "success") {
            tblHistorial.ajax.reload();
          }
        }
      };
    }
  });
}

function verVenta(idVenta) {
  const ruta = base_url + "ventas/ticket/" + idVenta;
  PopupCenter(ruta, "Ticket", "600", "500");
}

function PopupCenter(url, title, w, h) {
  // Fixes dual-screen position                         Most browsers      Firefox
  var dualScreenLeft =
    window.screenLeft != undefined ? window.screenLeft : window.screenX;
  var dualScreenTop =
    window.screenTop != undefined ? window.screenTop : window.screenY;

  var width = window.innerWidth
    ? window.innerWidth
    : document.documentElement.clientWidth
    ? document.documentElement.clientWidth
    : screen.width;
  var height = window.innerHeight
    ? window.innerHeight
    : document.documentElement.clientHeight
    ? document.documentElement.clientHeight
    : screen.height;

  var left = width / 2 - w / 2 + dualScreenLeft;
  var top = height / 2 - h / 2 + dualScreenTop;
  var newWindow = window.open(
    url,
    title,
    "scrollbars=yes, width=" +
      w +
      ", height=" +
      h +
      ", top=" +
      top +
      ", left=" +
      left
  );

  // Puts focus on the newWindow
  if (window.focus) {
    newWindow.focus();
  }
}
