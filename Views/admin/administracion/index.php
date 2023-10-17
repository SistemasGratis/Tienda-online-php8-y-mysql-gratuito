<?php include_once 'Views/template/header-admin.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Dashboard</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end page-title-box -->
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary mini-stat">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Pendientes</h6>
                    <h4 class="mb-3 mt-0 float-right">$<?php echo number_format((!empty($data['pendientesAct']['total'])) ? $data['pendientesAct']['total'] : 0, 2); ?></h4>
                </div>
                <div>
                    <span class="badge badge-light text-info"> <?php echo date('Y'); ?></span> <span class="ml-2">Año Actual</span>
                </div>

            </div>
            <div class="p-3">
                <div class="float-right">
                    <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
                </div>
                <p class="font-14 m-0">Anterior : $<?php echo number_format((!empty($data['pendientesAnt']['total'])) ? $data['pendientesAnt']['total'] : 0, 2); ?></p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-info mini-stat">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Completados</h6>
                    <h4 class="mb-3 mt-0 float-right">$<?php echo number_format((!empty($data['completadosAct']['total'])) ? $data['completadosAct']['total'] : 0, 2); ?></h4>
                </div>
                <div>
                    <span class="badge badge-light text-danger"> <?php echo date('Y'); ?> </span> <span class="ml-2">Año Actual</span>
                </div>
            </div>
            <div class="p-3">
                <div class="float-right">
                    <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
                </div>
                <p class="font-14 m-0">Anterior : $<?php echo number_format((!empty($data['completadosAnt']['total'])) ? $data['completadosAnt']['total'] : 0, 2); ?></p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-pink mini-stat">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Total</h6>
                    <h4 class="mb-3 mt-0 float-right">$<?php echo number_format($data['pendientesAct']['total'] + $data['completadosAct']['total'], 2); ?></h4>
                </div>
                <div>
                    <span class="badge badge-light text-primary"> <?php echo date('Y'); ?> </span> <span class="ml-2">Año Actual</span>
                </div>
            </div>
            <div class="p-3">
                <div class="float-right">
                    <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
                </div>
                <p class="font-14 m-0">Anterior : $<?php echo number_format($data['pendientesAnt']['total'] + $data['pendientesAnt']['total'], 2); ?></p>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div id="chart3"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card">
            <div class="card-body mb-3">
                <div id="chart8"></div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<?php include_once 'Views/template/footer-admin.php'; ?>

<!-- dashboard js -->
<script src="<?php echo BASE_URL; ?>public/admin/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/admin/js/page/dashboard.js"></script>

</body>

</html>