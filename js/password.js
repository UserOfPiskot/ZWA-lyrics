const eyeImage = new Image();
eyeImage.src = "img/password-eye.png";

function showEye() {
  /*const img = new Image();
  img.src = "img/password-eye.png";*/

  console.log("eyeing");
  const canvas = document.getElementById("password-canvas");
  if (!canvas) return;
  const ctx = canvas.getContext("2d");
  console.log("canvas good");

  canvas.setAttribute("aria-label", "Password Eye Canvas");
  canvas.setAttribute("role", "img");
  canvas.setAttribute("tabindex", "0");
  canvas.setAttribute("title", "Click to toggle password visibility");

  const imgWidth = 48;
  const imgHeight = 48;
  const renderWidth = 48;
  const renderHeight = 48;
  const defaultFrame = 10
      
  canvas.width = imgWidth;
  canvas.height = imgHeight;

  eyeImage.onload = () => {
    ctx.drawImage(eyeImage, 0, 48 * defaultFrame, imgWidth, imgHeight, 0, 0, renderWidth, renderHeight);
  };
}

function showPassword() {
  var input = document.getElementById("password");
  var isPassword = input.type === "text";

  input.type = isPassword ? "password" : "text";
  blinkEye(isPassword);
}

function blinkEye(isClosing) {
  var canvas = document.getElementById("password-canvas");
  if (!canvas) return;
  var ctx = canvas.getContext("2d");
  /*const img = new Image();
  img.src = "img/password-eye.png";*/

  const imgWidth = 48;
  const imgHeight = 48;
  const renderWidth = 48;
  const renderHeight = 48;
  const totalFrames = 14;
  const frameTime = 40;

  canvas.width = imgWidth;
  canvas.height = imgHeight;

  //eyeImage.onload = () => {
    for (let i = 0; i < totalFrames; i++) {
      const eyePos = isClosing ? i : totalFrames - 1 - i;
      setTimeout(() => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(eyeImage, 0, imgHeight * eyePos, imgWidth, imgHeight, 0, 0, renderWidth, renderHeight);
      }, i * frameTime);
    };
//}
}