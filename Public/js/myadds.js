// Store the original HTML
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
    document.getElementById("goBackButton").addEventListener("click", function() {
        restoreOriginalContent();
    });
}

// Function to restore the original content
function restoreOriginalContent() {
    document.getElementById("productContainer").outerHTML = originalHTML;
    
    // Reattach the click event for "Write A Review"
    document.getElementById("writeReviewLink").addEventListener("click", function(e) {
        e.preventDefault(); // Prevent default link behavior
        showReviewForm(); // Show review form when clicked
    });
}

// Attach the click event for "Write A Review" on page load
document.getElementById("writeReviewLink").addEventListener("click", function(e) {
    e.preventDefault(); // Prevent default link behavior
    showReviewForm(); // Show review form when clicked
});