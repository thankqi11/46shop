/**
 * Hàm hiển thị thông báo tùy chỉnh (Giữ lại)
 * @param {string} message - Nội dung thông báo
 */
function alertMessage(message) {
  const msgBox = document.getElementById("message-box");
  if (!msgBox) return;

  msgBox.textContent = message;
  msgBox.classList.add("show");

  // Tự động ẩn sau 3 giây
  setTimeout(() => {
    msgBox.classList.remove("show");
  }, 3000);
}

document.addEventListener("DOMContentLoaded", () => {
  // --- Xử lý Trang Đăng Nhập ---
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    // XÓA logic submit form. Form sẽ được submit qua PHP.
    // loginForm.addEventListener("submit", (event) => { ... });
  }

  // Link chuyển từ Đăng nhập sang Đăng ký (Giữ nguyên)
  const registerLink = document.getElementById("go-to-register");
  if (registerLink) {
    registerLink.addEventListener("click", (event) => {
      event.preventDefault();
      // Đổi đường dẫn thành tệp PHP
      window.location.href = "register.php";
    });
  }

  // Xử lý sự kiện Quên mật khẩu (Giữ nguyên)
  const forgotLink = document.querySelector(".forgot-password-link");
  if (forgotLink) {
    forgotLink.addEventListener("click", (event) => {
      event.preventDefault();
      alertMessage("Chức năng Quên mật khẩu đang được phát triển.");
    });
  }
});
