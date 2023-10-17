const contenedorCarritoProductos = document.querySelector("#carrito-productos");
const contenedorTotal = document.querySelector("#total");

let productos,
  productosjson = [];
document.addEventListener("DOMContentLoaded", function () {
  if (localStorage.getItem("productos-en-carrito") != null) {
    productos = JSON.parse(localStorage.getItem("productos-en-carrito"));
  } else {
    productos = [];
  }
  mostrarProductos();

  numerito.textContent = productos.length;
  numerito1.textContent = productos.length;

});

function mostrarPaypal(total) {
  paypal
    .Buttons({
      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
        return actions.order.create({
          application_context: {
            shipping_preference: "NO_SHIPPING",
          },
          purchase_units: [
            {
              amount: {
                currency_code: "USD",
                value: total,
                breakdown: {
                  item_total: {
                    /* Required when including the `items` array */
                    currency_code: "USD",
                    value: total,
                  },
                },
              },
              items: productosjson,
            },
          ],
        });
      },
      // Finalize the transaction after payer approval
      onApprove(data, actions) {
        return actions.order.capture().then(function (orderData) {
          fetch(ruta + "registro/registrarPedido", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              pedidos: orderData,
              productos: productos,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              alerta(data.msg, 1);
              if (data.icono == "success") {
                productos.length = 0;
                localStorage.setItem(
                  "productos-en-carrito",
                  JSON.stringify(productos)
                );
                setTimeout(function () {
                  window.location = ruta + 'principal/complete';
                }, 1500);
              }
            });
        });
      },
    })
    .render("#paypal-button-container");
}

function mostrarProductos() {
  fetch(ruta + "principal/listaProductos", {
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(productos),
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      html = "";
      data.productos.forEach((producto) => {
        html += `<tr class="table-primary">
        <td class="shoping__cart__item">
                <img src="${ruta + "public/img/productos/" + producto.imagen
          }" alt="${producto.nombre}" width="50">
                <h5>${producto.nombre}</h5>
            </td>
		      <td class="shoping__cart__price">${producto.cantidad}</td>
		      <td class="shoping__cart__quantity">
                <div class="quantity">
                    <div class="pro-qty">
                        <input type="text" value="${producto.cantidad}">
                    </div>
                </div>
            </td>
            <td class="shoping__cart__total">
                $ ${producto.subTotal}
            </td>
	  </tr>`;
        //agregrar producto para paypal
        let json = {
          name: producto.nombre,
          /* Shows within upper-right dropdown during payment approval */
          unit_amount: {
            currency_code: "USD",
            value: producto.precio,
          },
          quantity: producto.cantidad,
        };
        productosjson.push(json);
      });
      contenedorCarritoProductos.innerHTML = html;
      contenedorTotal.textContent = "$" + data.total;
      document.getElementById("paypal-button-container").innerHTML = "";
      mostrarPaypal(data.totalPaypal);
    });
}