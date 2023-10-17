const frm = document.querySelector("#formulario");
const email = document.querySelector("#email");
const clave = document.querySelector("#clave");
document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (email.value == "" || clave.value == "") {
        Toastify({
            text: 'Todo los campos son requeridos',
            duration: 3000,
            position: "right", // `left`, `center` or `right`
            textTransform: "uppercase",
            style: {
              background: "linear-gradient(to right, #FF1426, #FC208B)",
            },
          }).showToast();
    } else {
      let data = new FormData(this);
      const url = base_url + "admin/validar";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res.icono == "success") {
            window.location = base_url + "admin/home";
          }
          Toastify({
            text: res.msg,
            duration: 3000,
            position: "right", // `left`, `center` or `right`
            textTransform: "uppercase",
            style: {
              background: "linear-gradient(to right, #FF1426, #FC208B)",
            },
          }).showToast();
        }
      };
    }
  });
});
