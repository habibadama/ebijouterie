<?php
// views/confirmation.php
require_once 'views/header.php';
?>

<div class="container confirmation-container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Carte de confirmation principale -->
            <div class="confirmation-card card shadow-lg border-0 overflow-hidden">
                <!-- En-tête avec effet de vague -->
                <div class="confirmation-header position-relative">
                    <div class="confirmation-wave"></div>
                    <div class="confirmation-hero text-center text-white position-relative py-5">
                        <div class="confirmation-success-icon mb-4">
                            <div class="success-icon-circle">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="success-pulse"></div>
                        </div>
                        <h1 class="confirmation-title display-6 fw-bold mb-3">Commande Confirmée !</h1>
                        <p class="confirmation-subtitle lead mb-0 opacity-90">Votre commande a été enregistrée avec succès</p>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Message de remerciement -->
                    <div class="confirmation-thankyou text-center mb-5">
                        <h3 class="thankyou-title h4 fw-semibold text-dark mb-3">
                            <i class="fas fa-gift me-2 text-warning"></i>
                            Merci pour votre confiance
                        </h3>
                        <p class="thankyou-message text-muted mb-0">
                            Nous sommes ravis de vous compter parmi nos clients. Votre commande est en cours de préparation.
                        </p>
                    </div>

                    <!-- Récapitulatif de commande -->
                    <div class="order-summary-section mb-5">
                        <div class="summary-header text-center mb-4">
                            <h4 class="summary-title fw-bold text-dark mb-2">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                Récapitulatif de commande
                            </h4>
                            <p class="summary-description text-muted">Conservez ces informations pour le suivi</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="summary-info-card">
                                    <div class="info-card-icon">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Numéro de commande</span>
                                        <p class="info-card-value">#<?= $purchase['id'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-info-card">
                                    <div class="info-card-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Date de commande</span>
                                        <p class="info-card-value"><?= date('d/m/Y à H:i', strtotime($purchase['created_at'])) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-info-card">
                                    <div class="info-card-icon">
                                        <i class="fas fa-euro-sign"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Montant total</span>
                                        <p class="info-card-value price-highlight"><?= formatPrice($purchase['total_price']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-info-card">
                                    <div class="info-card-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Statut</span>
                                        <div class="order-status-badge status-processing">
                                            <i class="fas fa-clock me-1"></i>
                                            En traitement
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Détails des articles -->
                    <?php if (!empty($items)): ?>
                        <div class="order-items-section mb-5">
                            <h5 class="items-section-title fw-semibold text-dark mb-3">
                                <i class="fas fa-boxes me-2 text-warning"></i>
                                Articles commandés
                            </h5>
                            <div class="order-items-list">
                                <?php foreach ($items as $item): ?>
                                    <div class="order-item-card">
                                        <div class="item-card-image">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                            <?php else: ?>
                                                <div class="item-image-placeholder">
                                                    <i class="fas fa-gem"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="item-card-details">
                                            <h6 class="item-card-name"><?= htmlspecialchars($item['name']) ?></h6>
                                            <p class="item-card-quantity text-muted">Quantité: <?= $item['quantity'] ?></p>
                                        </div>
                                        <div class="item-card-price">
                                            <?= formatPrice($item['price'] * $item['quantity']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Prochaines étapes -->
                    <div class="delivery-steps-section mb-5">
                        <h5 class="steps-section-title fw-semibold text-dark mb-4 text-center">
                            <i class="fas fa-road me-2 text-info"></i>
                            Prochaines étapes
                        </h5>
                        <div class="delivery-timeline">
                            <div class="delivery-step step-completed">
                                <div class="step-indicator">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-details">
                                    <h6 class="step-title fw-semibold">Commande validée</h6>
                                    <p class="step-description text-muted small mb-0">Votre paiement a été accepté</p>
                                </div>
                            </div>
                            <div class="delivery-step step-current">
                                <div class="step-indicator">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="step-details">
                                    <h6 class="step-title fw-semibold">Préparation en cours</h6>
                                    <p class="step-description text-muted small mb-0">Nous préparons votre commande</p>
                                </div>
                            </div>
                            <div class="delivery-step step-pending">
                                <div class="step-indicator">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="step-details">
                                    <h6 class="step-title fw-semibold">Expédition</h6>
                                    <p class="step-description text-muted small mb-0">Envoi sous 24-48h</p>
                                </div>
                            </div>
                            <div class="delivery-step step-pending">
                                <div class="step-indicator">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="step-details">
                                    <h6 class="step-title fw-semibold">Livraison</h6>
                                    <p class="step-description text-muted small mb-0">Réception à domicile</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="confirmation-actions">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="index.php?action=catalogue" class="btn btn-primary btn-action-primary w-100 py-3">
                                    <i class="fas fa-gem me-2"></i>
                                    Continuer mes achats
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php?action=home" class="btn btn-outline-secondary btn-action-secondary w-100 py-3">
                                    <i class="fas fa-home me-2"></i>
                                    Retour à l'accueil
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="confirmation-footer text-center mt-5 pt-4 border-top">
                        <p class="footer-info text-muted small mb-2">
                            <i class="fas fa-envelope me-1"></i>
                            Un email de confirmation vous a été envoyé
                        </p>
                        <p class="footer-info text-muted small mb-0">
                            <i class="fas fa-clock me-1"></i>
                            Délai de livraison estimé : 3-5 jours ouvrés
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --success-color: #27ae60;
        --success-light: rgba(39, 174, 96, 0.1);
        --primary-color: #2c3e50;
        --warning-color: #f39c12;
        --info-color: #3498db;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-radius: 16px;
        --border-radius-sm: 12px;
        --shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s ease;
    }

    /* Container principal */
    .confirmation-container {
        padding-top: 80px;
    }

    /* Carte de confirmation */
    .confirmation-card {
        border-radius: var(--border-radius);
        background: white;
    }

    /* En-tête avec vague */
    .confirmation-header {
        background: linear-gradient(135deg, var(--success-color) 0%, #2ecc71 100%);
        position: relative;
        overflow: hidden;
    }

    .confirmation-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='white'%3E%3C/path%3E%3C/svg%3E");
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }

    .confirmation-hero {
        z-index: 2;
    }

    /* Icône de succès */
    .confirmation-success-icon {
        position: relative;
        display: inline-block;
    }

    .success-icon-circle {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        position: relative;
        z-index: 2;
    }

    .success-pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: confirmationPulse 2s infinite;
        z-index: 1;
    }

    @keyframes confirmationPulse {
        0% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -50%) scale(1.5);
            opacity: 0;
        }
    }

    .confirmation-title {
        font-size: 2.5rem;
    }

    .confirmation-subtitle {
        font-size: 1.25rem;
    }

    /* Cartes d'information du résumé */
    .summary-info-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: var(--light-bg);
        border-radius: var(--border-radius-sm);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        height: 100%;
    }

    .summary-info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .info-card-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .info-card-content {
        flex-grow: 1;
    }

    .info-card-label {
        display: block;
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .info-card-value {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0;
        font-size: 1.1rem;
    }

    .price-highlight {
        color: var(--success-color);
        font-size: 1.25rem;
    }

    /* Badge de statut */
    .order-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
    }

    .status-processing {
        background: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
    }

    /* Liste des articles */
    .order-item-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition);
    }

    .order-item-card:hover {
        background: var(--light-bg);
        border-radius: var(--border-radius-sm);
    }

    .order-item-card:last-child {
        border-bottom: none;
    }

    .item-card-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .item-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.25rem;
    }

    .item-card-details {
        flex-grow: 1;
    }

    .item-card-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .item-card-quantity {
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .item-card-price {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    /* Timeline de livraison */
    .delivery-timeline {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .delivery-timeline::before {
        content: '';
        position: absolute;
        top: 40px;
        left: 30px;
        right: 30px;
        height: 2px;
        background: var(--border-color);
        z-index: 1;
    }

    .delivery-step {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }

    .delivery-step:last-child {
        margin-bottom: 0;
    }

    .step-indicator {
        width: 60px;
        height: 60px;
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--text-muted);
        flex-shrink: 0;
        transition: var(--transition);
    }

    .step-completed .step-indicator {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .step-current .step-indicator {
        background: var(--warning-color);
        border-color: var(--warning-color);
        color: white;
        animation: stepBounce 2s infinite;
    }

    .step-pending .step-indicator {
        background: var(--light-bg);
        border-color: var(--border-color);
        color: var(--text-muted);
    }

    @keyframes stepBounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: scale(1);
        }

        40% {
            transform: scale(1.1);
        }

        60% {
            transform: scale(1.05);
        }
    }

    .step-details {
        flex-grow: 1;
        padding-top: 0.5rem;
    }

    .step-title {
        margin-bottom: 0.25rem;
    }

    /* Boutons d'action */
    .btn-action-primary,
    .btn-action-secondary {
        border-radius: var(--border-radius-sm);
        border: none;
        font-weight: 600;
        transition: var(--transition);
        padding: 1rem 1.5rem;
    }

    .btn-action-primary:hover,
    .btn-action-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .confirmation-container {
            padding-top: 60px;
        }

        .confirmation-title {
            font-size: 1.75rem;
        }

        .success-icon-circle {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .success-pulse {
            width: 100px;
            height: 100px;
        }

        .summary-info-card {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .order-item-card {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
            padding: 1.5rem 1rem;
        }

        .delivery-timeline::before {
            display: none;
        }

        .delivery-step {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .step-indicator {
            align-self: center;
        }

        .btn-action-primary,
        .btn-action-secondary {
            padding: 0.875rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .confirmation-header .py-5 {
            padding: 2rem 0 !important;
        }

        .summary-info-card {
            padding: 1rem;
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .order-item-card {
            padding: 1rem 0.5rem;
        }

        .item-card-image {
            width: 50px;
            height: 50px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée des éléments
        const animateConfirmationElements = () => {
            const elements = document.querySelectorAll('.summary-info-card, .order-item-card, .delivery-step');

            elements.forEach((element, index) => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    element.style.opacity = "1";
                    element.style.transform = "translateY(0)";
                }
            });
        };

        // Initialiser les styles d'animation
        const animatedElements = document.querySelectorAll('.summary-info-card, .order-item-card, .delivery-step');
        animatedElements.forEach(element => {
            element.style.opacity = "0";
            element.style.transform = "translateY(20px)";
            element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        });

        // Déclencher l'animation
        setTimeout(animateConfirmationElements, 100);
        window.addEventListener('scroll', animateConfirmationElements);
    });
</script>

<?php require_once 'views/footer.php'; ?>