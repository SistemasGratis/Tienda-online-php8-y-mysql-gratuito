<?php 
include_once 'Views/template/header-admin.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h4 class="page-title m-0">Ventas</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end page-title-box -->
    </div>
</div>
<!-- end page title -->

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center"><i class="fas fa-cash-register"></i> Nueva Venta</h5>
        <hr>

        <div class="row">
            <div class="col-lg-8">
                <!-- input para buscar nombre -->
                <div class="input-group mb-2" id="containerNombre">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="buscarProductoNombre" placeholder="Buscar Producto" autocomplete="off">
                </div>
                <span class="text-danger fw-bold mb-2" id="errorBusqueda"></span>
                <!-- table productos -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="tblNuevaVenta" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>SubTotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <div class="card text-white bg-info">
                      <div class="card-body text-center">
                        <h4 class="card-title" id="vacio"></h4>
                        <button id="btnVaciar" class="btn btn-danger" type="button" disabled><i class="fas fa-recycle"></i> Vaciar</button>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <label>Buscar Cliente</label>
                <div class="input-group mb-2">
                    <input type="hidden" id="idCliente">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="buscarCliente" placeholder="Buscar Cliente">
                </div>
                <span class="text-danger fw-bold mb-2" id="errorCliente"></span>

                <label>Dirección</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                    <input class="form-control" type="text" id="direccionCliente" placeholder="Dirección" disabled>
                </div>
                <label>Pagar con</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="pagar_con" placeholder="0.00">
                </div>
                <label>Cambio</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="cambio" placeholder="0.00" readonly>
                </div>
                <label>Total a Pagar</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="totalPagar" placeholder="Total Pagar" disabled>
                    <input class="form-control" type="hidden" id="totalPagarHidden">
                </div>

                <button class="btn btn-primary btn-block" type="button" id="btnAccion">Completar</button>

            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script src="<?php echo BASE_URL . 'public/admin/js/jquery-ui.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'public/admin/js/page/ventas.js'; ?>"></script>

</body>

</html>