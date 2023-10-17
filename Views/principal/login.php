<?php include "Views/template/header.php"; ?>
<main>
    <h2 class="titulo-principal">Login</h2>
    <div class="contenedor-carrito">

        <div class="form-structor">
            <div class="signup">
                <h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
                <div class="form-holder">
                    <input type="text" id="nameRegister" class="input" placeholder="Name" />
                    <input type="email" id="emailRegister" class="input" placeholder="Email" />
                    <input type="password" id="passwordRegister" class="input" placeholder="Password" />
                </div>
                <button class="submit-btn bg-white text-dark" id="btnRegister">Sign up</button>
            </div>
            <div class="login slide-up">
                <div class="center">
                    <h2 class="form-title" id="login"><span>or</span>Log in</h2>
                    <div class="form-holder mb-3">
                        <input type="email" id="email" class="input" placeholder="Email" />
                        <input type="password" id="password" class="input" placeholder="Password" />
                    </div>
                    <a href="<?php echo BASE_URL . 'principal/recoverpw'; ?>">Olvidaste tu contraseña?</a>
                    <button class="submit-btn" id="btnLogin">Log in</button>
                </div>
            </div>
        </div>
    </div>
</main>
</div>

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/admin/js/jquery.min.js"></script>
<script>
    const base_url = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>public/js/menu.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/login1.js"></script>
</body>

</html>