function showToast(message, type){
  const toastContainer = document.getElementById("toast-container");

  const toast = document.createElement("div");
  toast.className = "toast " + type;
  toast.setAttribute("role", "alert");
  toast.setAttribute("aria-live", "assertive");
  
  const toastMessage = document.createElement("span");
  toastMessage.textContent = message;

  toast.appendChild(toastMessage);

  if(type === "error"){
    const closeButton = new Image();

    closeButton.src = "assets/img/close-button.png";
    closeButton.width = 25;
    closeButton.height = 25;
    closeButton.className = "close-toast-button";
    closeButton.onclick = () => {
      toast.classList.remove("show");
      setTimeout(() => {
        toast.remove();
      }, 300);
    };

    toast.appendChild(closeButton);
  } else {
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => {
        toast.remove();
      }, 300);
    }, 3000);
  }

  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("show");
  }, 10);
}