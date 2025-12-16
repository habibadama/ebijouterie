<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBijouterie - Bijoux Artisanaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="index.php?action=home">
                    <span class="logo-icon me-2">
                        <i class="fas fa-gem"></i>
                    </span>
                    <span>eBijouterie</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Navigation Links -->
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['action'] ?? '') === 'home' ? 'active' : '' ?>"
                                href="index.php?action=home">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['action'] ?? '') === 'catalogue' ? 'active' : '' ?>"
                                href="index.php?action=catalogue">Catalogue</a>
                        </li>

                        <!-- Panier -->
                        <li class="nav-item ms-lg-3">
                            <a href="index.php?action=cart" class="cart-icon position-relative <?= ($_GET['action'] ?? '') === 'cart' ? 'active' : '' ?>">
                                <i class="fas fa-shopping-bag"></i>
                                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                    <span class="cart-badge">
                                        <?= count($_SESSION['cart']) ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                            <!-- Version connectée -->
                            <li class="nav-item dropdown ms-lg-3">
                                <!-- ✅ PROPRE - Bootstrap seulement -->
                                <a class="nav-link dropdown-toggle d-flex align-items-center"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown">
                                    <div class="user-avatar me-2">
                                        <span class="avatar-initials">
                                            <?=
                                            strtoupper(substr($_SESSION['user_lastname'] ?? 'U', 0, 1)) .
                                                strtoupper(substr($_SESSION['user_firstname'] ?? 'S', 0, 1))
                                            ?>
                                        </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item <?= ($_GET['action'] ?? '') === 'profile' ? 'active' : '' ?>"
                                            href="index.php?action=profile">
                                            <i class="fas fa-user me-2"></i>Mon Profil
                                        </a>
                                    </li>

                                    <?php if (!isset($_SESSION['user_roles']) || !in_array('ROLE_ADMIN', $_SESSION['user_roles'])): ?>
                                        <li>
                                            <a class="dropdown-item" href="index.php?action=my-orders">
                                                <i class="fas fa-receipt me-2"></i>Mes Commandes
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['user_roles']) && in_array('ROLE_ADMIN', $_SESSION['user_roles'])): ?>
                                        <li>
                                            <a class="dropdown-item text-warning <?= strpos($_GET['action'] ?? '', 'admin') === 0 ? 'active' : '' ?>"
                                                href="index.php?action=admin">
                                                <i class="fas fa-crown me-2"></i>Administration
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="index.php?action=logout">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <?php else: ?>
                            <!-- Version non connectée -->
                            <li class="nav-item ms-lg-3">
                                <a class="nav-link <?= ($_GET['action'] ?? '') === 'login' ? 'active' : '' ?>"
                                    href="index.php?action=login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Connexion
                                </a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-outline-primary <?= ($_GET['action'] ?? '') === 'register' ? 'active' : '' ?>"
                                    href="index.php?action=register">
                                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main style="margin-top: 80px;">