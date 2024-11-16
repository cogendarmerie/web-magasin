const modal = document.querySelector("#modal_deletion");

document.querySelector("#delete-user").addEventListener("click", function(e) {
    // Annuler l'action par défault
    e.preventDefault();
    modal.classList.toggle("show");
});

// Modal
modal.querySelector("button[data-action='confirm']").addEventListener("click", function(e){
   e.preventDefault();

   // Redirection pour procéder a la suppression
    window.location.href = this.dataset.href;
});

modal.querySelector("button[data-action='cancel']").addEventListener("click", function(e){
   e.preventDefault();
   modal.classList.remove("show");
});