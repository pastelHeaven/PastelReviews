document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".like-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const reviewId = button.dataset.reviewId; 
            let currentLikes = parseInt(button.dataset.likes); 

            fetch("like_review.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `review_id=${reviewId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "liked") {
                      
                        currentLikes++;
                        button.dataset.likes = currentLikes; 
                        button.innerHTML = `<img src="img/" alt="Like icon" /> ${currentLikes} Likes`;
                    } else if (data.status === "unliked") {
                        // Decrement the like count
                        currentLikes--;
                        button.dataset.likes = currentLikes; 
                        button.innerHTML = `<img src="img/like.png" alt="Like icon" /> ${currentLikes} Likes`;
                    } else if (data.error) {
                        console.error(data.error); 
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    });
});
