const frm = document.querySelector("#frmRegistro");

const nombre = document.querySelector("#nombre");
const telefono = document.querySelector("#telefono");
const correo = document.querySelector("#correo");
const direccion = document.querySelector("#direccion");
const id = document.querySelector("#id");

document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      correo.value == "" ||
      nombre.value == "" ||
      telefono.value == "" ||
      direccion.value == ""
    ) {
      alertas("TODO LOS CAMPOS SON REQUERIDOS", 2);
    } else {
      const url = base_url + "negocio/modificar";
      let data = new FormData(this);
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          let type = res.type == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
});
