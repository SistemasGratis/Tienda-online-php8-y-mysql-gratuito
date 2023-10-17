<!-- Footer Section Begin -->
<footer class="footer spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="footer__about">
          <div class="footer__about__logo">
            <a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="" width="50"></a>
          </div>
          <ul>
            <li>Address: <?php echo $data['negocio']['direccion']; ?></li>
            <li>Phone: <?php echo $data['negocio']['telefono']; ?></li>
            <li>Email: <?php echo $data['negocio']['correo']; ?></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
        <div class="footer__widget">
          <h6>Links</h6>
          <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Productos</a></li>
            <li><a href="#">Contáctenos</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="footer__widget">
          <h6>Únase a nuestro boletín ahora</h6>
          <p>Reciba actualizaciones por correo electrónico sobre nuestra última tienda y ofertas especiales.</p>
          <form action="#">
            <input type="text" placeholder="Introduce tu correo">
            <button type="submit" class="site-btn">Suscribir</button>
          </form>
          <div class="footer__widget__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-pinterest"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="footer__copyright">
          <div class="footer__copyright__text">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>
                document.write(new Date().getFullYear());
              </script> All rights reserved </a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
          <div class="footer__copyright__payment"><img src="<?php echo BASE_URL; ?>public/img/payment-item.png" alt=""></div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="<?php echo BASE_URL; ?>public/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/jquery.nice-select.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/jquery.slicknav.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/mixitup.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/owl.carousel.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/main.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/toastify-js.js"></script>
<script>
  const ruta = '<?php echo BASE_URL; ?>';
  function alerta(mensaje, type) {
  let color = type == 1 ? "#46cd93" : "#f24734";
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
</script>
<script src="<?php echo BASE_URL; ?>public/js/sweetalert2.all.min.js"></script>
