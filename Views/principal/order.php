<?php include "Views/template/header.php"; ?>

<section class="shoping-cart spad">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5">LOGIN</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="form-structor">
                            <div class="signup">
                                <h2 class="form-title" id="signup"><span>or</span>Registrarse</h2>
                                <div class="form-holder">
                                    <input type="text" id="nameRegister" class="input" placeholder="Name" />
                                    <input type="email" id="emailRegister" class="input" placeholder="Email" />
                                    <input type="password" id="passwordRegister" class="input" placeholder="Password" />
                                </div>
                                <button class="submit-btn bg-white text-dark" id="btnRegister">Registrarse</button>
                            </div>
                            <div class="login slide-up">
                                <div class="center">
                                    <h2 class="form-title" id="loginForm"><span>or</span>Login</h2>
                                    <div class="form-holder mb-3">
                                        <input type="email" id="email" class="input" placeholder="Email" />
                                        <input type="password" id="password" class="input" placeholder="Password" />
                                    </div>
                                    <a href="<?php echo BASE_URL . 'principal/recoverpw'; ?>">Olvidaste tu contraseña?</a>
                                    <button class="submit-btn" id="btnLogin">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/admin/js/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/login.js"></script>
</body>

</html>