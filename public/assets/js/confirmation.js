function copyLink($path) {
    navigator.clipboard.writeText($path).then(function() {
        Swal.fire("Lien copié", "Le lien de l'ambassadeur a été copié avec succès.", "success");
    });
}