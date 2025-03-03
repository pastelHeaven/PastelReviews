document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get("game_id");

    if (!gameId) {
        document.querySelector(".game-details-container").innerHTML = "<p>Error: Game ID not found.</p>";
        return;
    }
    //Add the game id on the review html
    document.getElementById("review-link").href = `review.html?game_id=${gameId}`;

    // Fetch Game Details
    fetch(`fetch_game_details.php?game_id=${gameId}`)
        .then(response => response.json())
        .then(game => {
            if (!game || game.error) {
                throw new Error(game.error || "Game not found.");
            }

            document.getElementById("game-title").textContent = game.title;
            document.getElementById("game-des").textContent = game.description || "No description available.";
            document.getElementById("game-date").textContent = `Release Date: ${game.release_date || "Unknown"}`;
            document.getElementById("game-genre").textContent = `Genres: ${game.genre || "N/A"}`;
            document.getElementById("game-platform").textContent = `Platforms: ${game.platform || "N/A"}`;
            document.getElementById("game-poster").src = game.cover ? game.cover : "img/placeholder.png";

            // After fetching game details, load reviews
            loadReviews();
        })
        .catch(error => {
            console.error("Error fetching game details:", error);
            document.querySelector(".game-details-container").innerHTML = `<p>Error loading game details.</p>`;
        });

    // Function to Load Reviews
    function loadReviews() {
        fetch(`get_reviews.php?game_id=${gameId}`)
            .then(response => response.json())
            .then(reviews => {
                const reviewsContainer = document.getElementById("reviews-container");
                reviewsContainer.innerHTML = "";

                if (reviews.length === 0) {
                    reviewsContainer.innerHTML = "<p>No reviews available for this game.</p>";
                } else {
                    reviews.forEach(review => {
                        const reviewElement = `
                            <div class="review-container">
                                <strong>${review.username}</strong>
                                <p>${review.comment}</p>
                                <span>Rating: ${"⭐".repeat(review.rating)}</span>
                                <span>Platform: ${review.platform}</span>
                            </div>
                        `;
                        reviewsContainer.insertAdjacentHTML("beforeend", reviewElement);
                    });
                }
            })
            .catch(error => console.error("Error fetching reviews:", error));
    }


});
