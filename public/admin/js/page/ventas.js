const errorBusqueda = document.querySelector("#errorBusqueda");
const inputBuscarNombre = document.querySelector("#buscarProductoNombre");
const tblVenta = document.querySelector("#tblNuevaVenta tbody");

const errorCliente = document.querySelector("#errorCliente");
const direccionCliente = document.querySelector("#direccionCliente");
const idCliente = document.querySelector("#idCliente");

const pagar_con = document.querySelector("#pagar_con");
const totalPagar = document.querySelector("#totalPagar");
const totalPagarHidden = document.querySelector("#totalPagarHidden");
const cambio = document.querySelector("#cambio");
const btnAccion = document.querySelector("#btnAccion");
const vacio = document.querySelector("#vacio");
const btnVaciar = document.querySelector("#btnVaciar");
document.addEventListener("DOMContentLoaded", function () {
  $("#buscarProductoNombre").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "ventas/buscarProducto",
        dataType: "json",
        data: {
          term: request.term,
        },
        success: function (data) {
          response(data);
          if (data.length > 0) {
            errorBusqueda.textContent = "";
          } else {
            errorBusqueda.textContent = "NO HAY PRODUCTO CON ESE NOMBRE";
          }
        },
      });
    },
    minLength: 2,
    select: function (event, ui) {
      agregarProducto(ui.item.id);
      inputBuscarNombre.value = "";
      inputBuscarNombre.focus();
      return false;
    },
  });
  mostrarCarrito();
  //autocomplete clientes
  $("#buscarCliente").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: base_url + "ventas/buscarCliente",
        dataType: "json",
        data: {
          term: request.term,
        },
        success: function (data) {
          response(data);
          if (data.length > 0) {
            errorCliente.textContent = "";
          } else {
            errorCliente.textContent = "NO HAY CLIENTE CON ESE NOMBRE";
          }
        },
      });
    },
    minLength: 2,
    select: function (event, ui) {
      direccionCliente.value = ui.item.direccion;
      idCliente.value = ui.item.id;
    },
  });

  //calcular cambio
  pagar_con.addEventListener("keyup", function (e) {
    if (totalPagar.value != "") {
      let totalCambio =
        parseFloat(e.target.value) - parseFloat(totalPagarHidden.value);
      cambio.value = totalCambio.toFixed(2);
    }
  });

  btnAccion.addEventListener("click", function () {
    let filas = document.querySelectorAll("#tblNuevaVenta tr").length;
    if (filas < 2) {
      alertas("NO HAY PRODUCTOS AGREGADOS", 2);
      return;
    } else {
      const url = base_url + "ventas/registrar";
      //hacer una instancia del objeto XMLHttpRequest
      const http = new XMLHttpRequest();
      //Abrir una Conexion - POST - GET
      http.open("POST", url, true);
      //Enviar Datos
      http.send(
        JSON.stringify({
          idCliente: idCliente.value,
          pago: pagar_con.value,
        })
      );
      //verificar estados
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          let type = res.type == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
          if (res.type == "success") {
            setTimeout(() => {
              const ruta = base_url + "ventas/ticket/" + res.idVenta;
              PopupCenter(ruta, "Ticket", "600", "500");
              window.location.reload();
            }, 1500);
          }
        }
      };
    }
  });

  btnVaciar.addEventListener("click", function () {
    Swal.fire({
      title: "Advertencia?",
      text: "Eliminar productos del carrito!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        const url = base_url + "ventas/vaciarCarrito";
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let type = res.type == "success" ? 1 : 2;
            alertas(res.msg.toUpperCase(), type);
            mostrarCarrito();
          }
        };
      }
    });
  });
});

function agregarProducto(idProducto) {
  const url = base_url + "ventas/agregarProducto/" + idProducto;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let type = res.type == "success" ? 1 : 2;
      alertas(res.msg.toUpperCase(), type);
      if (res.type == "success") {
        mostrarCarrito();
      }
    }
  };
}

function mostrarCarrito() {
  const url = base_url + "ventas/listarCarrito";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.productos.length > 0) {
        let html = "";
        tblNuevaVenta.classList.remove("d-none");
        let mensaje = res.productos.length > 1 ? "PRODUCTOS" : "PRODUCTO";
        vacio.textContent =
          res.productos.length + " " + mensaje + " EN EL CARRITO";
        btnVaciar.removeAttribute("disabled");
        for (let i = 0; i < res.productos.length; i++) {
          let subTotal =
            parseFloat(res.productos[i].attributes.price) *
            parseInt(res.productos[i].quantity);
          html += `<tr>
              <td>${res.productos[i].attributes.nombre}</td>
              <td>${res.productos[i].attributes.price}</td>
              <td>${res.productos[i].quantity}</td>
              <td>${subTotal.toFixed(2)}</td>
              <td><button class="btn btn-danger btn-sm" onclick="deleteCart(${
                res.productos[i].id
              })"><i class="fas fa-trash"></i></button></td>
          </tr>`;
        }
        tblVenta.innerHTML = html;
        totalPagarHidden.value = res.totalS;
        totalPagar.value = res.totalF;
      } else {
        tblNuevaVenta.classList.add("d-none");
        vacio.textContent = "No hay productos";
        btnVaciar.setAttribute("disabled", "disabled");
      }
    }
  };
}

function deleteCart(id) {
  const url = base_url + "ventas/deleteCarrito/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let type = res.type == "success" ? 1 : 2;
      alertas(res.msg.toUpperCase(), type);
      if (res.type == "success") {
        mostrarCarrito();
      }
    }
  };
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
