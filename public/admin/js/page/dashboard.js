$(function () {
  "use strict";
  pedidosMes();
  topGrafico();
});

function pedidosMes() {
  fetch(base_url + "admin/comprasMes")
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function (info) {
      var options = {
        series: [
          {
            name: "Pedidos",
            data: [
              info.pedido.ene,
              info.pedido.feb,
              info.pedido.mar,
              info.pedido.abr,
              info.pedido.may,
              info.pedido.jun,
              info.pedido.jul,
              info.pedido.ago,
              info.pedido.sep,
              info.pedido.oct,
              info.pedido.nov,
              info.pedido.dic,
            ],
          },
          {
            name: "Ventas",
            data: [
              info.venta.ene,
              info.venta.feb,
              info.venta.mar,
              info.venta.abr,
              info.venta.may,
              info.venta.jun,
              info.venta.jul,
              info.venta.ago,
              info.venta.sep,
              info.venta.oct,
              info.venta.nov,
              info.venta.dic,
            ],
          },
        ],
        chart: {
          foreColor: '#9ba7b2',
          height: 360,
          type: 'area',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          },
        },
        colors: ["#0d6efd", "#f41127"],
        title: {
          text: "Reporte Gráfico",
          align: "left",
          style: {
            fontSize: "16px",
            color: "#666",
          },
        },
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: "smooth",
        },
        xaxis: {
          type: "",
          categories: [
            "Ene",
            "Feb",
            "Mar",
            "Abr",
            "May",
            "Jun",
            "Jul",
            "Ago",
            "Sep",
            "Oct",
            "Nov",
            "Dic",
          ],
        },
      };
      var chart = new ApexCharts(document.querySelector("#chart3"), options);
      chart.render();
    });
}
function topGrafico() {
  fetch(base_url + "admin/topProductos")
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function (info) {
      let productos = [];
      let cantidad = [];

      for (let i = 0; i < info.length; i++) {
        productos.push(info[i]["nombre"]);
        cantidad.push(info[i]["ventas"]);
      }

      var options = {
        series: cantidad,
        chart: {
          foreColor: "#9ba7b2",
          height: 360,
          type: "pie",
          zoom: {
            enabled: false,
          },
          toolbar: {
            show: true,
          },
        },
        title: {
          text: "Productos mas vendidos",
          align: "left",
          style: {
            fontSize: "16px",
            color: "#666",
          },
        },
        legend: {
          position: "bottom",
        },
        colors: ["#0d6efd", "#6c757d", "#17a00e", "#f41127", "#ffc107"],
        labels: productos,
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                height: 360,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      };
      var chart = new ApexCharts(document.querySelector("#chart8"), options);
      chart.render();
    });
}
// sb-zclre14462343@personal.example.com
// Email ID:

// #D)0R9]i
