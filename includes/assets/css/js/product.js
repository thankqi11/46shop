document.addEventListener("DOMContentLoaded", () => {
  const minusBtn = document.getElementById("qty-minus");
  const plusBtn = document.getElementById("qty-plus");
  const qtyInput = document.getElementById("qty-input");

  let quantity = parseInt(qtyInput.value);

  // Function to update the quantity
  const updateQuantity = (newQuantity) => {
    // Ensure quantity is at least 1
    quantity = Math.max(1, newQuantity);
    qtyInput.value = quantity;
  };

  // Event listener for the minus button
  minusBtn.addEventListener("click", () => {
    updateQuantity(quantity - 1);
  });

  // Event listener for the plus button
  plusBtn.addEventListener("click", () => {
    updateQuantity(quantity + 1);
  });
});
