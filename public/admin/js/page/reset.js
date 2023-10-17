const frm = document.querySelector("#formulario");
const nueva = document.querySelector("#nueva");
const confirmar = document.querySelector("#confirmar");
const token = document.querySelector("#token");
document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (nueva.value == "" || confirmar.value == "" || token.value == "") {
      alertas("Todo los campos son requeridos", 2);
    } else {
      let data = new FormData(this);
      const url = base_url + "principal/cambiarClave";
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
function alertas(mensaje, type) {
  let color = type == 1 ? "#46cd93" : "#f24734";
  Toastify({
    text: mensaje,
    duration: 3000,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "right", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    style: {
      background: color,
      borderRadius: "2rem",
      textTransform: "uppercase",
      fontSize: ".75rem",
    },
    offset: {
      x: "1.5rem", // horizontal axis - can be a number or a string indicating unity. eg: '2em'
      y: "1.5rem", // vertical axis - can be a number or a string indicating unity. eg: '2em'
    },
    onClick: function () {}, // Callback after click
  }).showToast();
}
