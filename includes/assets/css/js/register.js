function alertMessage(message) {
  const msgBox = document.getElementById("message-box");
  if (!msgBox) return;

  msgBox.textContent = message;
  msgBox.classList.add("show");

  setTimeout(() => {
    msgBox.classList.remove("show");
  }, 3000);
}

document.addEventListener("DOMContentLoaded", () => {
  const backToLoginLink = document.querySelector(".back-to-login-link");
  if (backToLoginLink) {
    backToLoginLink.addEventListener("click", (event) => {});
  }
});
