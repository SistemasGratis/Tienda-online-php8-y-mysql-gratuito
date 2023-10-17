<?php include "Views/template/header.php"; ?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-danger mb-2" href="<?php echo BASE_URL . 'profile/salir'; ?>" role="button">Cerrar Sesion</a>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle" style="width: 100%;" id="tblPendientes">
                <thead>
                    <tr>
                        <th>Productos</th>
                        <th>Fecha</th>
                        <th>Transacción</th>
                        <th>Monto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalEnvio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Dirección de envio</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="lista">
            </div>
        </div>
    </div>
</div>

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/admin/js/jquery.min.js"></script>
<script>
    const base_url = '<?php echo BASE_URL; ?>';
</script>
<script type="text/javascript" src="<?php echo BASE_URL . 'public/admin/DataTables/datatables.min.js'; ?>"></script>
<script src="<?php echo BASE_URL; ?>public/admin/js/es-ES.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/pedidos.js"></script>
</body>

</html>