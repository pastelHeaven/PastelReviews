//This js file handles getting data from my database and diaplays it on my game reveiw html using the gameid to find the specfic game deatail.
// this using the file uses fetch_game_details.php which is reponsible of finding the game deails from my database uisng fetch() withe the ${gameId} 
// this also handle review using the get_reviews.php which is simular to fetch_game_details.php as we are getting data from my databas but this time is the reveiews

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get("game_id");

    // This is for debugging if the retuen a gameid, i have commment this part out as it not needed due to me swithcing from api to using my database to get the data 
    // if (!gameId) {
    //     document.querySelector(".game-details-container").innerHTML = "<p>Error: Game ID not found.</p>";
    //     return;
    // }
    
    //thsi takes the game id from the game grid and adds it on the review html
    document.getElementById("log-review-btn").href = `review.html?game_id=${gameId}`;

    // This is for fetch Game Details using the gamed id and finds it from the database as its uses a php file
    fetch(`fetch_game_details.php?game_id=${gameId}`)
        .then(response => response.json())
        .then(game => {
            if (!game || game.error) {
                throw new Error(game.error || "Game not found.");
            
            }
            // This is for getting the game details from the database and display it on the review html using text.connent rather than innnerhtml(as its not safe to use
            // due to servirty risk)
            document.getElementById("game-title").textContent = game.title;
            document.getElementById("game-des").textContent = game.description || "No description available.";
            document.getElementById("game-date").textContent = `Release Date: ${game.release_date || "Unknown"}`;
            document.getElementById("game-genre").textContent = `Genres: ${game.genre || "Unknown"}`;
            document.getElementById("game-platform").textContent = `Platforms: ${game.platform || "Unknown"}`;
            document.getElementById("game-poster").src = game.cover ? game.cover : "img/placeholder.png";

            // After its fetch the game details thsi funcion load the reviews
            loadingReviews();
        })
        .catch(error => {
            console.error("Error fetching game details:", error);
            document.querySelector(".game-details-container").innerHTML = `<p>Error with loading game details.</p>`;
        });

    // this Function to Load Reviews
    function loadingReviews() {
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
