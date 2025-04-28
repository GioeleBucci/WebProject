// @ts-nocheck
// function underlineProductName(toggle) {
//     const productName = this.querySelector('.product-name');
//     if (productName) {
//         productName.style.textDecoration = toggle ? 'underline' : 'none';
//     }
// }

function toggleWishlist() {
    // Get the article ID from the data attribute
    const articleId = this.getAttribute('data-article-id');

    // Create form data for the request
    const formData = new FormData();
    formData.append('articleId', articleId);

    const heartIcon = this.querySelector('i');
    const wishlistTextDiv = this.querySelector('.wishlist-text');
    
    // Disable the button during the request to prevent multiple clicks
    this.disabled = true;    
    
    console.log('Sending wishlist request for article ID:', articleId);
    fetch('/WebProject/website/src/utils/toggleWishlist.php', {
        method: 'POST',
        body: formData,
        credentials: 'include' // Include cookies for session
    })
    .then(async response => {
        if (!response.ok) {
            let errorMessage = `Server returned ${response.status}`;
            
            try {
                const errorData = await response.json();
                if (errorData && errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (e) {
                const text = await response.text();
                if (text) {
                    errorMessage = text;
                }
            }
            
            throw new Error(errorMessage);
        }
        
        try {
            return response.json();
        } catch (e) {
            throw new Error('Invalid JSON response');
        }
    })
    .then(data => {
        console.log('Wishlist toggle response:', data);
        
        if (data.success) {
            // Toggle the heart icon based on the response
            if (data.inWishlist) {
                heartIcon.classList.remove('bi-heart');
                heartIcon.classList.add('bi-heart-fill');
                // Update wishlist text div
                if (wishlistTextDiv) {
                    wishlistTextDiv.textContent = 'Remove from Wishlist';
                }
            } else {
                heartIcon.classList.remove('bi-heart-fill');
                heartIcon.classList.add('bi-heart');
                // Update wishlist text div
                if (wishlistTextDiv) {
                    wishlistTextDiv.textContent = 'Add to Wishlist';
                }
            }
        } else {
            console.error('Failed to toggle wishlist:', data.message || 'Unknown error');
            alert('Could not update wishlist. Please try again later.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Could not update wishlist: ' + error.message);
    })
    .finally(() => {
        // Re-enable the button after the request completes
        this.disabled = false;
    });
}
