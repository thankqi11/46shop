/**
 * Hàm hiển thị thông báo tùy chỉnh (thay thế cho alert())
 * Giữ lại vì PHP không thể hoàn toàn thay thế hiệu ứng message box này.
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
  // Logic xử lý form Đăng ký đã được chuyển sang PHP.
  // Không cần phải có code JavaScript xử lý sự kiện submit form nữa.

  // Link Quay lại đăng nhập
  const backToLoginLink = document.querySelector(".back-to-login-link");
  if (backToLoginLink) {
    backToLoginLink.addEventListener("click", (event) => {
      // Chỉ cần đảm bảo link hoạt động, nhưng tốt nhất là dùng href tĩnh
    });
  }

  // Xóa các khối xử lý form login, register, forgot link nếu không cần thiết
  // để tránh trùng lặp nếu bạn dùng tệp này riêng cho dangki.html/php
});
