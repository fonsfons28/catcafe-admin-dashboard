document.addEventListener("DOMContentLoaded", () => {

    // JS for Dynamic Order Calculation
    const orderForm = document.querySelector("form"); // only run if form exists
    if (orderForm) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="food_id[]"]');
        const totalDisplay = document.createElement("p"); 
        totalDisplay.innerHTML = 'Total Price: ₱<span id="total-display">0.00</span>';
        
        // Insert above submit button
        const submitButton = orderForm.querySelector('button[type="submit"]');
        submitButton.parentNode.insertBefore(totalDisplay, submitButton);

        function updateTotal() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const foodId = cb.value;
                    const qtyInput = document.querySelector('input[name="quantity_' + foodId + '"]');
                    const quantity = parseInt(qtyInput.value) || 1;
                    const priceText = cb.nextElementSibling.textContent.match(/₱([0-9.,]+)/);
                    if (priceText) {
                        const price = parseFloat(priceText[1].replace(',', ''));
                        total += price * quantity;
                    }
                }
            });
            document.getElementById("total-display").textContent = total.toFixed(2);
        }

        // Add event listeners
        checkboxes.forEach(cb => {
            cb.addEventListener("change", updateTotal);
            const foodId = cb.value;
            const qtyInput = document.querySelector('input[name="quantity_' + foodId + '"]');
            qtyInput.addEventListener("input", updateTotal);
        });

        // Initialize total
        updateTotal();
    }

});
