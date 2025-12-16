<div class="login-container">
    <div class="login-wrapper">
        <!-- Section image -->
        <div class="login-image-section">
            <img src="assets/images/banner-img.avif" alt="Bijoux de luxe eBijouterie" class="login-image">
            <div class="image-overlay">
                <div class="overlay-content">
                    <i class="fas fa-gem"></i>
                    <h2>eBijouterie</h2>
                    <p>Créations exclusives</p>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="login-form-section">
            <div class="login-card">
                <div class="login-header">
                    <h1>Connexion</h1>
                    <p>Accédez à votre compte</p>
                </div>

                <div class="login-body">
                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?= $error ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?action=login" class="login-form">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-input" name="email"
                                    value="<?= $_POST['email'] ?? '' ?>"
                                    placeholder="Adresse email"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-input" name="password"
                                    placeholder="Mot de passe"
                                    required>
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" name="remember">
                                <span class="checkmark"></span>
                                Se souvenir de moi
                            </label>
                            <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                        </div>

                        <button type="submit" class="login-btn">
                            Se connecter
                        </button>
                    </form>

                    <div class="login-footer">
                        <p>Pas de compte ?
                            <a href="index.php?action=register" class="register-link">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ========================================================================== 
   LOGIN 
   ========================================================================== */
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .login-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1000px;
        width: 100%;
        background: var(--white);
        border-radius: 24px;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
        min-height: 550px;
        position: relative;
    }

    /* Effet d'ombre portée */
    .login-wrapper::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: -10px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 24px;
        z-index: -1;
        filter: blur(15px);
    }

    /* Section image */
    .login-image-section {
        position: relative;
        overflow: hidden;
    }

    .login-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        filter: brightness(0.9);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
                rgba(0, 0, 0, 0.4) 0%,
                rgba(0, 0, 0, 0.2) 50%,
                rgba(212, 175, 55, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .overlay-content {
        text-align: center;
        color: var(--white);
        text-shadow:
            0 2px 10px rgba(0, 0, 0, 0.6),
            0 0 30px rgba(0, 0, 0, 0.4);
    }

    .overlay-content i {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        opacity: 0.95;
        filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.5));
    }

    .overlay-content h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        letter-spacing: 0.5px;
    }

    .overlay-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin: 0;
        font-weight: 300;
        letter-spacing: 0.5px;
    }

    /* Fallback si l'image ne charge pas */
    .login-image-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
        z-index: -1;
    }

    /* Formulaire */
    .login-form-section {
        padding: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        position: relative;
    }

    .login-card {
        width: 100%;
        max-width: 380px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .login-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        letter-spacing: 0.5px;
    }

    .login-header p {
        color: var(--text-light);
        font-size: 1rem;
        margin: 0;
        font-weight: 400;
    }

    /* Alert */
    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 10px rgba(220, 38, 38, 0.1);
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #DC2626;
    }

    .alert-error i {
        color: #DC2626;
    }

    /* Formulaire */
    .login-form {
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        color: var(--gray);
        font-size: 1.1rem;
        z-index: 2;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--gold-primary);
        background: var(--white);
        box-shadow:
            inset 0 1px 3px rgba(0, 0, 0, 0.05),
            0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    .form-input::placeholder {
        color: #94a3b8;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        color: var(--gold-primary);
        background: rgba(212, 175, 55, 0.1);
    }

    /* Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        font-size: 0.9rem;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        color: var(--text-dark);
        font-weight: 500;
    }

    .checkbox-wrapper input {
        display: none;
    }

    .checkmark {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .checkbox-wrapper input:checked+.checkmark {
        background: var(--gold-primary);
        border-color: var(--gold-primary);
    }

    .checkbox-wrapper input:checked+.checkmark::after {
        content: '✓';
        color: var(--white);
        font-size: 0.8rem;
        font-weight: bold;
    }

    .forgot-password {
        color: var(--gold-primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .forgot-password:hover {
        color: var(--gold-dark);
        text-decoration: underline;
    }

    /* Bouton */
    .login-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
        border: none;
        color: var(--white);
        padding: 1.125rem 2rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow:
            0 4px 15px rgba(212, 175, 55, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow:
            0 8px 25px rgba(212, 175, 55, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    /* Footer */
    .login-footer {
        text-align: center;
        color: var(--text-light);
        font-size: 0.95rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }

    .register-link {
        color: var(--gold-primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-link:hover {
        color: var(--gold-dark);
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-container {
            min-height: 70vh;
            padding: 1rem;
        }

        .login-wrapper {
            grid-template-columns: 1fr;
            max-width: 450px;
            min-height: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .login-wrapper::before {
            display: none;
        }

        .login-image-section {
            display: none;
        }

        .login-form-section {
            padding: 2.5rem 2rem;
        }

        .form-options {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .login-form-section {
            padding: 2rem 1.5rem;
        }

        .login-header h1 {
            font-size: 2rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const passwordToggle = document.querySelector('.password-toggle');
        const passwordInput = document.querySelector('input[name="password"]');

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }

        // Fallback si l'image ne charge pas
        const loginImage = document.querySelector('.login-image');
        if (loginImage) {
            loginImage.addEventListener('error', function() {
                this.style.display = 'none';
            });
        }
    });
</script>

<?php require_once 'views/footer.php'; ?>