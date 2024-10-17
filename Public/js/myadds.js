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
function decreaseQty(productId, price) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    const cartItemRow = document.getElementById(`cart-item-row-${productId}`); 

    let currentValue = parseInt(qtyInput.value);


    // If the value becomes 0, remove the entire row from the table
    if (currentValue == 1) {
        removeFromCart(productId); 
        cartItemRow.remove(); 
    } else if (currentValue > 1) {
        currentValue -= 1;
        qtyInput.value = currentValue;

    }
    updateCartTotal( false, price); 

}

// Function to increase the quantity
function increaseQty(productId, price) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    let currentValue = parseInt(qtyInput.value);

    if (currentValue < parseInt(qtyInput.max)) {
        currentValue += 1;
        qtyInput.value = currentValue;
        updateCartTotal( true, price); // true for increasing
    }
}



// Function to update the total amount in the cart summary
function updateCartTotal(isAdd, price) {
    // Retrieve and clean the subtotal and shipping fee from the DOM
    const subtotalText = document.getElementById('subtotal-price').textContent.replace('$', '');
    const shippingFeeText = document.getElementById('shipping-fee').textContent.replace('$', '');

    // Convert values to numbers
    const shippingFeeNum = parseFloat(shippingFeeText) || 0;
    const itemPriceNum = parseFloat(price) || 0;
    const subtotalPriceNum = parseFloat(subtotalText) || 0;

    // Update subtotal and total based on whether adding or removing an item
    let newSubtotalNum, newTotalNum;

    if (isAdd) {
        newSubtotalNum = subtotalPriceNum + itemPriceNum;
    } else {
        newSubtotalNum = subtotalPriceNum - itemPriceNum;
    }
    
    newTotalNum = newSubtotalNum + shippingFeeNum;

    if (newSubtotalNum == 0) {
        document.getElementById('shipping-fee').textContent = '$0.00';
        newTotalNum = 0;
    } 

    // Update the DOM with the new values
    document.getElementById('subtotal-price').textContent = `$${newSubtotalNum.toFixed(2)}`;
    document.getElementById('total-price').textContent = `$${newTotalNum.toFixed(2)}`;
}




// Function to call PHP and remove the item from the cart
function removeFromCart(productId) {
    const xhr = new XMLHttpRequest();  // Create new AJAX request
    xhr.open("POST", "remove_from_cart.php", true);  // Specify the PHP file to call
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the request with item details (e.g., item ID)
    xhr.send(`item_id=${productId}`);

    // Handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Item removed from cart");
        } else {
            console.error("Failed to remove item from cart");
        }
    };
}
// ### Cart End ###
