const numerito = document.querySelector("#numerito");
const numerito1 = document.querySelector("#numerito1");
const search = document.querySelector("#buscarproducto");
let productos;
document.addEventListener("DOMContentLoaded", function () {
  if (localStorage.getItem("productos-en-carrito") != null) {
    productos = JSON.parse(localStorage.getItem("productos-en-carrito"));
  } else {
    productos = [];
  }

  cantidadCarrito();

  cargarBotones()
});

function cargarBotones(){
  let botonesAgregar = document.querySelectorAll(".producto-agregar");
  for (let i = 0; i < botonesAgregar.length; i++) {
    botonesAgregar[i].addEventListener("click", function (e) {
        e.preventDefault();
      let idProducto = botonesAgregar[i].id;
      let stock = botonesAgregar[i].getAttribute("stock");
      agregarCarrito(idProducto, 1, stock);
    });
  }
}
//agregar productos al carrito
function agregarCarrito(idProducto, cantidad, stock) {
  for (let i = 0; i < productos.length; i++) {
    if (productos[i]["id"] == idProducto) {
      productos[i]["cantidad"] = parseInt(productos[i]["cantidad"]) + 1;
      if (parseInt(stock) >= parseInt(productos[i]["cantidad"])) {
        alerta("PRODUCTO AGREGADO AL CARRITO", 1);
        localStorage.setItem("productos-en-carrito", JSON.stringify(productos));
      } else {
        alerta("STOCK AGOTADO", 2);
      }
      return;
    }
  }
  if (parseInt(stock) >= parseInt(1)) {
    productos.concat(localStorage.getItem("productos-en-carrito"));
    productos.push({
      id: idProducto,
      cantidad: cantidad,
    });
    localStorage.setItem("productos-en-carrito", JSON.stringify(productos));
    alerta("PRODUCTO AGREGADO AL CARRITO", 1);
    cantidadCarrito();
  } else {
    alerta("STOCK AGOTADO", 2);
  }
}

function cantidadCarrito() {
  numerito.textContent = productos.length;
  numerito1.textContent = productos.length;
}

function alerta(mensaje, type) {
  let color = (type == 1) ? '#46cd93' : '#f24734';
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
