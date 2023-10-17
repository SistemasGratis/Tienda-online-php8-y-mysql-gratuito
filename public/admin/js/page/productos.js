const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const cantidad = document.querySelector("#cantidad");

const foto_actual = document.querySelector("#imagen_actual");
const imagen = document.querySelector("#imagen");
let tblProductos;

const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));

document.addEventListener("DOMContentLoaded", function () {
  tblProductos = $("#tblProductos").DataTable({
    ajax: {
      url: base_url + "productos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "precio" },
      { data: "categoria" },
      { data: "cantidad" },
      { data: "imagen" },
      { data: "accion" },
    ],
    responsive: true,
    language,
    dom: "Bfrtip",
    buttons,
    order: [[0, "desc"]],
  });

  //levantar modal
  nuevo.addEventListener("click", function () {
    document.querySelector("#id").value = "";
    titleModal.textContent = "NUEVO PRODUCTO";
    btnAccion.textContent = "Registrar";
    document.querySelector("#container-img").innerHTML = ``;
    frm.reset();
    myModal.show();
    //$('#nuevoModal').modal('show');
  });

  imagen.addEventListener("change", function (e) {
    foto_actual.value = "";
    if (
      e.target.files[0].type == "image/png" ||
      e.target.files[0].type == "image/jpg" ||
      e.target.files[0].type == "image/jpeg"
    ) {
      const url = e.target.files[0];
      const tmpUrl = URL.createObjectURL(url);
      document.querySelector(
        "#container-img"
      ).innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">`;
    } else {
      imagen.value = "";
      alertas("SOLO SE PERMITEN IMG DE TIPO PNG-JPG-JPEG", 2);
    }
  });

  //submit productos
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    let data = new FormData(this);
    const url = base_url + "productos/registrar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        let type = res.icono == "success" ? 1 : 2;
        alertas(res.msg.toUpperCase(), type);
        if (res.icono == "success") {
          frm.reset();
          tblProductos.ajax.reload();
          document.querySelector("#imagen").value = "";
          myModal.hide();
        }
      }
    };
  });
});

function eliminarPro(idPro) {
  Swal.fire({
    title: "Aviso?",
    text: "Esta seguro de eliminar el registro!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "productos/delete/" + idPro;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res.icono == "success") {
            tblProductos.ajax.reload();
          }
          let type = res.icono == "success" ? 1 : 2;
          alertas(res.msg.toUpperCase(), type);
        }
      };
    }
  });
}

function editPro(idPro) {
  const url = base_url + "productos/edit/" + idPro;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.querySelector("#id").value = res.id;
      document.querySelector("#nombre").value = res.nombre;
      document.querySelector("#precio").value = res.precio;
      document.querySelector("#cantidad").value = res.cantidad;
      document.querySelector("#categoria").value = res.id_categoria;
      document.querySelector("#descripcion").value = res.descripcion;
      document.querySelector("#imagen_actual").value = res.imagen;
      document.querySelector(
        "#container-img"
      ).innerHTML = `<img class="img-thumbnail" src="${
        base_url + "public/img/productos/" + res.imagen
      }" width="300">`;
      btnAccion.textContent = "Actualizar";
      myModal.show();
    }
  };
}
