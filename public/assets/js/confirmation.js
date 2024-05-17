function copyLink($path) {
    navigator.clipboard.writeText($path).then(function() {
        Swal.fire("Lien copié", "Votre lien d'affiliation a été copié avec succès.", "success");
    });
}

function confirmation(url, text = "Êtes-vous sûr(e) de vouloir continuer? "){
    event.preventDefault();     
        Swal.fire({
            title: "Confirmation",
            text:text,
            showCancelButton: true,
            confirmButtonText: "Confirmer",
            cancelButtonText: "Annuler",
           
          }).then(function (t) {
            if(t.value !=null){
				window.location.href = url
			} 
});
}

function confirmationForm(form_id,url, text = "Êtes-vous sûr(e) de vouloir continuer? "){
    event.preventDefault();
    const form =document.getElementById(form_id);
    Swal.fire({
        title: "Confirmation",
        text:text,
        showCancelButton: true,
        confirmButtonText: "Confirmer",
        cancelButtonText: "Annuler",
       
      }).then(function (t) {
    if(t.value !=null){
        form.action=url;
        form.submit();
    } 
});
}