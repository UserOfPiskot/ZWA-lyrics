function openForm(name){
    const container = document.getElementById("change-account-container"); 
    const form = document.getElementById("account-" + name);
    form.classList.add("open");
    container.classList.add("open");
}
function closeForm(){
    const container = document.getElementById("change-account-container");
    const form = container.getElementsByClassName("open")[0];
    form.classList.remove("open");
    container.classList.remove("open");
}