document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);

  if (params.get('login') === '1') {
    openIFrame("login");
  }

  if (params.get('account') === '1') {
    openIFrame("account");
  }

  if (params.get('successfullAccountChange') === '1') {
    showToast("Change was successfully saved!", "success");
  }
});

window.addEventListener('message', (event) => {
  if (event.origin !== window.location.origin) {
    return;
  }

  if (event.data.action === 'showPasswordButtonCreated') {
    if (document.readyState === "complete") {
      showEye();
    } else {
      window.addEventListener("load", showEye, { once: true });
  }
}

  if (event.data.action === 'successfulLogin') {
    refreshPage();
  }
});