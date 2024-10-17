// ### Reviews Start ###
const originalHTML = document.getElementById("productContainer").outerHTML;

// Function to replace the content with the review form
function showReviewForm() {
    document.getElementById("productContainer").outerHTML = `
        <div class="container-fluid" id="productContainer">
            <div class="row">
                <div class="col-12">
                    <h2>Write Your Review</h2>
                    <form>
                        <textarea rows="5" cols="50" placeholder="Write your review here..."></textarea>
                        <br>
                        <button type="submit" class="btn amado-btn">Submit Review</button>
                    </form>
                    <button id="goBackButton" class="btn amado-btn">Go Back</button>
                </div>
            </div>
        </div>
    `;

    // Add event listener for "Go Back" button
    document.getElementById("goBackButton").addEventListener("click", function () {
        restoreOriginalContent();
    });
}

// Function to restore the original content
function restoreOriginalContent() {
    document.getElementById("productContainer").outerHTML = originalHTML;

    // Reattach the click event for "Write A Review"
    document.getElementById("writeReviewLink").addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default link behavior
        showReviewForm(); // Show review form when clicked
    });
}

// Attach the click event for "Write A Review" on page load
document.getElementById("writeReviewLink").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent default link behavior
    showReviewForm(); // Show review form when clicked
});

// ### Reviews End ###


// ### Cart Start ###

// Function to decrease the quantity and handle row removal
function decreaseQty() {
    const qtyInput = document.getElementById('qty');
    const cartItemRow = document.getElementById('cart-item-row'); // The row containing the item

    let currentValue = parseInt(qtyInput.value);

    // If the value is greater than the minimum, decrease the quantity
    if (currentValue > parseInt(qtyInput.min)) {
        currentValue -= 1;
        qtyInput.value = currentValue;
        updateCartTotal(currentValue);
    }

    // If the value becomes 0, remove the entire row from the table
    if (parseInt(qtyInput.value) === 0) {
        removeFromCart(); // Call function to remove item from cart (via PHP or backend)
        updateCartTotal(0);
        cartItemRow.remove(); // Remove the <tr> element from the DOM
    }

    updateCartTotal(currentValue);
}

// Function to increase the quantity
function increaseQty() {
    const qtyInput = document.getElementById('qty');
    let currentValue = parseInt(qtyInput.value);

    if (currentValue < parseInt(qtyInput.max)) {
        currentValue += 1;
        qtyInput.value = currentValue;
    }

    updateCartTotal(currentValue);
}

// Function to call PHP and remove the item from the cart
function removeFromCart() {
    const xhr = new XMLHttpRequest();  // Create new AJAX request
    xhr.open("POST", "remove_from_cart.php", true);  // Specify the PHP file to call
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the request with item details (e.g., item ID)
    const itemId = 123;  // Replace with actual item ID from your array
    xhr.send("item_id=" + itemId);

    // Handle the response (optional)
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Item removed from cart");
        } else {
            console.error("Failed to remove item from cart");
        }
    };
}


// Function to update the total amount in the cart summary
function updateCartTotal(amount) {
    const itemPrice = document.getElementById('item-price').textContent;
    const totalAmount = document.getElementById('total-price');
    const subtotalAmount = document.getElementById('subtotal-price');
    const shippingFee = document.getElementById('shipping-fee').textContent;

    // Convert values to numbers
    const itemPriceNum = parseFloat(itemPrice) || 0;
    const subtotalAmountNum = parseFloat(subtotalAmount) || 0;
    const shippingFeeNum = parseFloat(shippingFee) || 0;
    const amountNum = parseFloat(amount) || 0;

    subtotalAmount.textContent = `$${(amountNum * itemPriceNum).toFixed(2)}`;
    totalAmount.textContent = `$${(amountNum * itemPriceNum + shippingFeeNum).toFixed(2)}`;

}


// ### Cart End ###
