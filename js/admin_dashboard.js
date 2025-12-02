document.addEventListener("DOMContentLoaded", () => {

    // API for Finish Order Button
    document.querySelectorAll(".finish-order").forEach(button => {
        
        // Attach an event listener
        button.addEventListener("click", async (e) => {
           
            e.preventDefault();

            // get order id
            const orderId = button.dataset.id;

            // Confirm with User
            if (!confirm("Are you sure you want to mark this order as finished?")) return;

            try {
                
                // send request to finishOrder
                const res = await fetch(`finishOrder.php?id=${orderId}`, { method: "GET" });
                
                if (res.ok) {
                    // if good, remove the table
                    button.closest("tr").remove();
                } else {
                    // else, keep the table and show error message
                    alert("Error finishing order.");
                }
            } catch (err) {
                console.error(err);
                alert("Error finishing order.");
            }
        });
    });

// Finish Order Button
    document.querySelectorAll(".delete-order").forEach(button => {
        button.addEventListener("click", async (e) => {
            e.preventDefault();

            // get order id
            const orderId = button.dataset.id;

            if (!confirm("Are you sure you want to delete this order?")) return;

            // confirmation 
            try {
                const res = await fetch(`deleteOrder.php?id=${orderId}`, { method: "GET" });
                if (res.ok) {
                    // if okay, remove table row
                    button.closest("tr").remove();
                } else {
                    // else, keep the table and show error message
                    alert("Error deleting order.");
                }
            } catch (err) {
                console.error(err);
                alert("Error deleting order.");
            }
        });
    });
});
