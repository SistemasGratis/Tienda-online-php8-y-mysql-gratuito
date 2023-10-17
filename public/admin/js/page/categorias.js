const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const categoria = document.querySelector("#categoria");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));

const foto_actual = document.querySelector("#imagen_actual");
const imagen = document.querySelector("#imagen");

let tblCategorias;
document.addEventListener("DOMContentLoaded", function () {
    tblCategorias = $("#tblCategorias").DataTable({
        ajax: {
            url: base_url + "categorias/listar",
            dataSrc: "",
        },
        columns: [
            { data: "id" },
            { data: "categoria" },
            { data: "imagen" },
            { data: "accion" }
        ],
        language,
        dom: 'Bfrtip',
        buttons,
    });

    //levantar modal
    nuevo.addEventListener("click", function () {
        document.querySelector('#id').value = '';
        titleModal.textContent = "NUEVA CATEGORIA";
        btnAccion.textContent = 'Registrar';
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
    //submit categorias
    frm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (categoria.value == '') {
            alertas('LA CATEGORIA ES REQUERIDO', 2);
        } else {
            let data = new FormData(this);
            const url = base_url + "categorias/registrar";
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(data);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        myModal.hide();
                        tblCategorias.ajax.reload();
                        document.querySelector("#imagen").value = "";
                    }
                    let type = (res.icono == "success") ? 1 : 2;
                    alertas(res.msg.toUpperCase(), type);
                }
            }
        }
    });
});

function eliminarCat(idCat) {
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
            const url = base_url + "categorias/delete/" + idCat;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        tblCategorias.ajax.reload();
                    }
                    let type = (res.icono == "success") ? 1 : 2;
                    alertas(res.msg.toUpperCase(), type);
                }
            }
        }
    });
}

function editCat(idCat) {
    const url = base_url + "categorias/edit/" + idCat;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.querySelector('#id').value = res.id;
            document.querySelector('#categoria').value = res.categoria;
            btnAccion.textContent = 'Actualizar';
            titleModal.textContent = "MODIFICAR CATEGORIA";
            document.querySelector("#imagen_actual").value = res.imagen;
            document.querySelector(
                "#container-img"
            ).innerHTML = `<img class="img-thumbnail" src="${base_url + "public/img/categorias/" + res.imagen
                }" width="300">`;
            myModal.show();
            //$('#nuevoModal').modal('show');
        }
    }
}