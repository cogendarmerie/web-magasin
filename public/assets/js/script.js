document.querySelector('#nav-toggle').addEventListener("click", function(e) {
   e.preventDefault();

   // Toggle nav show
    document.querySelector('nav#left-nav').classList.toggle('open');
});