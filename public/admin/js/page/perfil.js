const apellido = document.querySelector("#apellido");
const nombre = document.querySelector("#nombre");
const clave = document.querySelector("#clave");
const usuario = document.querySelector("#usuario");
const correo = document.querySelector("#correo");
const direccion = document.querySelector("#direccion");
const frmPerfil = document.querySelector("#frmPerfil");
const frmPasword = document.querySelector("#frmPasword");
const actual = document.querySelector("#actual");
const nueva = document.querySelector("#nueva");
const confirmar = document.querySelector("#confirmar");

document.addEventListener("DOMContentLoaded", function () {
  frmPerfil.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      nombre.value == "" ||
      apellido.value == "" ||
      usuario.value == "" ||
      correo.value == "" ||
      direccion.value == ""
    ) {
      alertas("Todo los campos son requeridos", 2);
    } else {
      const url = base_url + "usuarios/actualizarPerfil";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(this));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });

  frmPasword.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      actual.value == "" ||
      nueva.value == "" ||
      confirmar.value == ""
    ) {
      alertas("Todo los campos son requeridos", 2);
    } else if(nueva.value != confirmar.value){
      alertas("Las contraseña no coinciden", 2);
    }else{
      const url = base_url + "usuarios/actualizarPassword";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(this));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
});
