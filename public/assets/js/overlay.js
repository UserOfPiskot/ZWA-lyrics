function openOverlayForm(type, name){
    const container = document.getElementById(`overlay-container`); 
    const form = document.getElementById(`${type}-${name}`);
    form.classList.add("open");
    container.classList.add("open");
}

function closeOverlayForm(){
    const container = document.getElementById("overlay-container");
    const form = container.getElementsByClassName("open")[0];
    form.classList.remove("open");
    container.classList.remove("open");
}

function updateCoverPreview(event){
    const inputedFiles = event.target.files;
    const preview = document.getElementById("cover-preview");
    if (inputedFiles.length > 0) {
        const file = inputedFiles[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    } else {
        preview.src = "assets/img/cover-placeholder.png"; // Reset to placeholder if no file is selected
    }
}