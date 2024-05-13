function copyLink($path) {
    navigator.clipboard.writeText($path).then(function() {
        Swal.fire("Lien copié", "Votre lien d'affiliation a été copié avec succès.", "success");
    });
}