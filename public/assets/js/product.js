const selectCategory = document.querySelector("select#categorie");
const form = document.querySelector("form");

selectCategory.addEventListener("change", function(e){
    const category = selectCategory.value;

    const groups = form.querySelectorAll(".group");
    groups.forEach((group) => {
        group.style.display = 'none';
    });

    const group = document.querySelector('#group-'+category);
    group.style.display = 'block';
});