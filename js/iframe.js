function createIFrame(name) {
  const IFrame = document.createElement("iframe");

  IFrame.src = "/" + name + ".php?backButton=1";
  IFrame.className = name + "-iframe iframe-slide";
  IFrame.title = name + " IFrame";

  document.body.appendChild(IFrame);

  return IFrame;
}

function createBackButton(name) {
  const button = new Image();

  button.id = "back-button";
  button.className = "back-button";
  button.src = "img/back-button.png";
  button.alt = "Back button";
  button.setAttribute("close-name", name)

  button.onclick = () => {
    const name = button.getAttribute("close-name");
    closeIFrame(name);
  };

  document.body.appendChild(button);

  return button;
}

function destroyIFrame(IFrame) {
  if (IFrame) {
    IFrame.remove();
  }
}

function destroyBackButton(button) {
  if (button) {
    button.remove();
  }
}

function openIFrame(name) {
  const params = new URLSearchParams(window.location.search);
  const nav = document.getElementsByClassName("nav-js")[0];
  
  const IFrame = document.getElementsByTagName("iframe")[0] || createIFrame(name);
  const backButton = document.getElementById("back-button") || createBackButton(name);

  if(!nav){
    console.log("Error: Navigation not found!");
    return;
  }

  window.parent.postMessage({ action: 'showPasswordButtonCreated' }, window.location.origin);


  params.set(name, '1');
  history.replaceState(null, '', '?' + params.toString());

  setTimeout(() => {
    nav.setAttribute("hidden", true);
  }, 500);
  void IFrame.offsetWidth;

  IFrame.style.left = "0";
  backButton.style.left = "0";

}

function closeIFrame(name) {
  const params = new URLSearchParams(window.location.search);
  const nav = document.getElementsByClassName("nav-js")[0];

  const IFrame = document.getElementsByTagName("iframe")[0];
  const backButton = document.getElementById("back-button");

  if(!nav){
    console.log("Error: Navigation not found!");
    return;
  }
  
  params.delete(name);
  history.replaceState(null, '', window.location.pathname + (params.toString() !== "" ? ('?' + params.toString()) : ''));

  IFrame.style.left = "100vw";
  backButton.style.left = "100vw";

  setTimeout(() => {
    nav.removeAttribute("hidden");

    destroyIFrame(IFrame);
    destroyBackButton(backButton);
  }, 500);
}

function refreshPage() {
  const params = new URLSearchParams(window.location.search);
  history.replaceState(null, '', window.location.pathname);
  window.location.reload();
}