// // Gestion des filtres
// document.addEventListener("DOMContentLoaded", function () {
//   // Filtres par catégorie
//   const categoryRadios = document.querySelectorAll('input[name="category"]');
//   categoryRadios.forEach((radio) => {
//     radio.addEventListener("change", function () {
//       if (this.checked) {
//         const url =
//           this.id === "cat-all"
//             ? "index.php?action=catalogue"
//             : `index.php?action=catalogue&category=${this.id.replace(
//                 "cat-",
//                 ""
//               )}`;
//         window.location.href = url;
//       }
//     });
//   });

// });



// // Gestion de la zone de glisser-déposer
//     const fileDropZone = document.getElementById('fileDropZone');
//     const fileInput = document.getElementById('image_upload');

//     // Événements pour la zone de glisser-déposer
//     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//         fileDropZone.addEventListener(eventName, preventDefaults, false);
//     });

//     function preventDefaults(e) {
//         e.preventDefault();
//         e.stopPropagation();
//     }

//     ['dragenter', 'dragover'].forEach(eventName => {
//         fileDropZone.addEventListener(eventName, () => fileDropZone.classList.add('active'), false);
//     });

//     ['dragleave', 'drop'].forEach(eventName => {
//         fileDropZone.addEventListener(eventName, () => fileDropZone.classList.remove('active'), false);
//     });

//     fileDropZone.addEventListener('drop', handleDrop, false);

//     function handleDrop(e) {
//         const dt = e.dataTransfer;
//         const files = dt.files;
//         fileInput.files = files;
//         handleFiles(files);
//     }

//     fileInput.addEventListener('change', function() {
//         handleFiles(this.files);
//     });

//     function handleFiles(files) {
//         const file = files[0];
//         if (file) {
//             // Validation
//             if (file.size > 2 * 1024 * 1024) {
//                 showNotification('Fichier trop volumineux! Maximum 2MB autorisé.', 'danger');
//                 fileInput.value = '';
//                 hideNewImagePreview();
//                 return;
//             }

//             const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
//             if (!allowedTypes.includes(file.type)) {
//                 showNotification('Type de fichier non autorisé! Formats acceptés: JPG, PNG, GIF, WebP', 'danger');
//                 fileInput.value = '';
//                 hideNewImagePreview();
//                 return;
//             }

//             // Afficher aperçu
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 const preview = document.getElementById('newImagePreviewContainer');
//                 preview.innerHTML = `
//                     <label class="form-label">Nouvelle image (aperçu)</label>
//                     <div class="image-preview-wrapper">
//                         <img src="${e.target.result}" alt="Aperçu" class="product-image-preview mb-3">
//                         <div class="mt-2"><small class="text-muted">Nouvelle image (aperçu)</small></div>
//                     </div>
//                 `;
//                 preview.style.display = 'block';
//             }
//             reader.readAsDataURL(file);
//         } else {
//             hideNewImagePreview();
//         }
//     }

//     function hideNewImagePreview() {
//         document.getElementById('newImagePreviewContainer').style.display = 'none';
//     }

//     function showNotification(message, type) {
//         // Créer une notification temporaire
//         const notificationDiv = document.createElement('div');
//         notificationDiv.className = `alert alert-${type} alert-notification alert-dismissible fade show position-fixed`;
//         notificationDiv.style.top = '20px';
//         notificationDiv.style.right = '20px';
//         notificationDiv.style.zIndex = '9999';
//         notificationDiv.style.minWidth = '300px';
//         notificationDiv.innerHTML = `
//             <div class="d-flex align-items-center">
//                 <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-3"></i>
//                 <div>${message}</div>
//             </div>
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//         `;

//         document.body.appendChild(notificationDiv);

//         // Supprimer la notification après 5 secondes
//         setTimeout(() => {
//             if (notificationDiv.parentNode) {
//                 notificationDiv.parentNode.removeChild(notificationDiv);
//             }
//         }, 5000);
//     }

//     // Validation du formulaire
//     document.getElementById('productEditForm').addEventListener('submit', function(e) {
//         const submitButton = document.getElementById('submitButton');
//         submitButton.disabled = true;
//         submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mise à jour en cours...';

//         // Laisser le formulaire s'envoyer normalement
//     });