document.addEventListener("DOMContentLoaded", () => {
  const canvas = document.getElementById("password-canvas");
  if (canvas) showEye();

  const params = new URLSearchParams(window.location.search);

  if (params.get('login') === '1') {
    openIFrame("login");
  }

  if (params.get('account') === '1') {
    openIFrame("account");
  }

  if (params.get('successfullAccountChange') === '1') {
    showToast("Change was successfully saved!", "success");
    params.delete("successfullAccountChange");
    history.replaceState(null, '', window.location.pathname + (params.toString() !== "" ? ('?' + params.toString()) : ''));
  }
});

window.addEventListener('message', (event) => {
  if (event.origin !== window.location.origin) {
    return;
  }

  if (event.data.action === 'successfulLogin') {
    refreshPage();
  }
});