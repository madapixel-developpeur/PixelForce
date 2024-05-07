//formulaire utilisé quand on veut ajouter un message de confirmation à un formulaire
function confirmationppal(form_id,url, text = "Êtes-vous sûr(e) de vouloir continuer? "){
    event.preventDefault();
    const form =document.getElementById(form_id);
    Swal.fire({
        title: "Confirmation",
        type: "warning",
        text: text,
        showCancelButton: !0,
        confirmButtonColor: "#67cfa2",
        cancelButtonColor: "#fc7383",
        confirmButtonText: "Confirmer",
        cancelButtonText: "Annuler",
        confirmButtonClass: "btn long",
        cancelButtonClass: "btn long bg-danger ml-1",
        buttonsStyling: !1,
        }).then(function (t) {
    if(t.value !=null){
        form.action=url;
        form.submit();
    } 
});
}

function confirmationPrint(message,url){
    event.preventDefault();
    const form =document.getElementById(form_id);
    Swal.fire({
        title: "Confirmation",
        type: "warning",
        text: message,
        showCancelButton: !0,
        confirmButtonColor: "#67cfa2",
        cancelButtonColor: "#fc7383",
        confirmButtonText: "Confirmer",
        cancelButtonText: "Annuler",
        confirmButtonClass: "btn long",
        cancelButtonClass: "btn long bg-danger ml-1",
        buttonsStyling: !1,
        }).then(function (t) {
    if(t.value !=null){
        window.location.href = url;
    } 
});
}
////

//fonction utilisé si on veut ajouter un message de confirmation à un simple bouton ou liens
function confirmAccept_simple_button(url, text = "Êtes-vous sûr(e) de vouloir continuer?"){
    event.preventDefault();
    Swal.fire({
        title: "Confirmation",
        text: text,
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#67cfa2",
        cancelButtonColor: "#fc7383",
        confirmButtonText: "Confirmer",
        cancelButtonText: "Annuler",
        confirmButtonClass: "btn long",
        cancelButtonClass: "btn long bg-danger ml-1",
        buttonsStyling: !1,
    }).then(function (t) {
        if(t.value){
            window.location.href =url
        } 
    });
}