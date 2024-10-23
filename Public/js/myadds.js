// ### Reviews Start ###

// Rating stars logic
function rateProduct(stars) {
    const starIcons = document.querySelectorAll('.rating-stars i');
    starIcons.forEach((star, index) => {
        if (index < stars) {
            star.classList.remove('fa-star-o');
            star.classList.add('fa-star');
        } else {
            star.classList.remove('fa-star');
            star.classList.add('fa-star-o');
        }
    });

    // Send the rating to PHP using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "product-details.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("starChosen=" + stars);
}

// Submit review logic
function submitReview() {
    const reviewText = document.getElementById('reviewText').value;
    const rating = document.querySelectorAll('.rating-stars .fa-star').length;

    if (reviewText && rating) {
        // Handle the form submission logic (AJAX or form post)
        alert('Review submitted: ' + reviewText + ', Rating: ' + rating + ' stars');
        restoreOriginalContent(); // Restore to the product view after successful review submission
    } else {
        alert('Please enter a review and select a rating.');
    }
}

// Function to show the review form and hide product container
function showReviewForm() {
    const productContainer = document.getElementById('productContainer');
    const reviewsContainer = document.getElementById('reviewsContainer');

    productContainer.classList.add('d-none');  // Hide product container
    reviewsContainer.classList.remove('d-none');  // Show reviews form

    // Add event listener for "Go Back" button
    document.getElementById('goBackButton').addEventListener('click', restoreOriginalContent);
}

// Function to restore the original product view
function restoreOriginalContent() {
    const productContainer = document.getElementById('productContainer');
    const reviewsContainer = document.getElementById('reviewsContainer');

    reviewsContainer.classList.add('d-none');  // Hide reviews form
    productContainer.classList.remove('d-none');  // Show product container
}

// Attach the click event for "Write A Review" on page load
document.getElementById('writeReviewLink').addEventListener('click', function (e) {
    e.preventDefault();  // Prevent default link behavior
    showReviewForm();  // Show review form when clicked
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
        currentValue -= 1;
        cartItemRow.remove();
    } else if (currentValue > 1) {
        currentValue -= 1;
        qtyInput.value = currentValue;

    }
    updateCartTotal(false, price);
    updateCart(productId, currentValue);

}

// Function to increase the quantity
function increaseQty(productId, price) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    let currentValue = parseInt(qtyInput.value);

    if (currentValue < parseInt(qtyInput.max)) {
        currentValue += 1;
        qtyInput.value = currentValue;
        updateCartTotal(true, price); // true for increasing
        updateCart(productId, currentValue);
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




function updateCart(productId, quantity) {
    const xhr = new XMLHttpRequest();  // Create a new AJAX request
    xhr.open("POST", "../core.php", true);  // Specify the PHP file to call
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the request with product_id and quantity
    xhr.send(`product_id=${productId}&quantity=${quantity}`);

    // Handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Cart updated successfully");
        } else {
            console.error("Failed to update cart");
        }
    };
}


// ### Cart End ###



// ### Carusel START ###

class ReviewsCarousel {
    constructor() {
        // DOM Elements
        this.carousel = document.querySelector('.reviews-carousel');
        this.carouselInner = this.carousel.querySelector('.reviews-carousel-inner');
        this.cards = Array.from(this.carousel.querySelectorAll('.review-card'));
        this.prevBtn = this.carousel.querySelector('.carousel-control.prev');
        this.nextBtn = this.carousel.querySelector('.carousel-control.next');

        // State
        this.currentIndex = 0;
        this.autoPlayInterval = null;
        this.autoPlayDelay = 5000; // 5 seconds

        // Initialize
        this.init();
    }

    init() {
        // Set up initial state
        this.updateActiveCard();

        // Event listeners
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());

        // Touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;

        this.carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        this.carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        });

        // Start autoplay
        this.startAutoPlay();

        // Pause autoplay on hover
        this.carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.carousel.addEventListener('mouseleave', () => this.startAutoPlay());
    }

    updateActiveCard() {
        this.cards.forEach((card, index) => {
            card.classList.toggle('active', index === this.currentIndex);
        });

        this.carouselInner.style.transform = `translateX(-${this.currentIndex * 100}%)`;
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.cards.length;
        this.updateActiveCard();
    }

    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.cards.length) % this.cards.length;
        this.updateActiveCard();
    }

    handleSwipe(touchStartX, touchEndX) {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.next();
            } else {
                this.prev();
            }
        }
    }

    startAutoPlay() {
        if (!this.autoPlayInterval) {
            this.autoPlayInterval = setInterval(() => this.next(), this.autoPlayDelay);
        }
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}

// Initialize the carousel when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ReviewsCarousel();
});


// ### Carusel END ###




function togglePaymentMethod() {
    const codCheckbox = document.getElementById("cod");
    const cardInfo = document.getElementById("card-info");
    const cardHolder = document.getElementById("card-holder");
    const expDate = document.getElementById("exp-date");
    const fullNameContainer = document.getElementById("fullNameContainer");

    if (codCheckbox.checked) {
        cardInfo.style.display = "none";
        cardHolder.style.display = "none";
        expDate.style.display = "none";
        fullNameContainer.style.display = "block"; 
    } else {
        cardInfo.style.display = "block";
        cardHolder.style.display = "block";
        expDate.style.display = "block";
        fullNameContainer.style.display = "none"; 
    }
}


function validateAndSubmit() {
    const form = document.getElementById('checkoutForm');
    const requiredInputs = form.querySelectorAll('input[required], select[required]');
    
    let allFilled = true;

    requiredInputs.forEach(input => {
        if (input.offsetParent !== null) { 
            if (!input.value) {
                allFilled = false; 
                input.classList.add('is-invalid'); 
            } else {
                input.classList.remove('is-invalid');
            }
        }
    });

  
    if (allFilled) {
        form.submit();
        alert("Thank you, we recieved your purchase.");
    } else {
        alert("Please fill in all required fields."); 
    }
}



