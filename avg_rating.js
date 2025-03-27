//this file is used to fetch the average rating of a game from the database and display it on the game page

document.addEventListener("DOMContentLoaded", function () {
    // this gets the game id from the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get("game_id");
    const averagerating = document.querySelector(".rating-score");

// this is for debugges to check if the game id is founded
    // if (!gameId) {
    //     console.error("Game ID not found.");
    //     return;
    //   }

    // this function fetches the average rating from the database using the game id and the avg_rating.php file
    // and displays it on the page
    async function getaveragerating() {
      try {
        const response = await fetch(`avg_rating.php?game_id=${gameId}`);
        if (!response.ok) throw new Error("Failed to fetch average rating");
  
        const data = await response.json();
        if (data.average_rating) {
            averagerating.textContent = data.average_rating;
        } else {
          averagerating.textContent = "No ratings yet";
        }
      } catch (error) {
        console.error(error);
        averagerating.textContent = "Error loading rating";
      }
    }
    
  // this function is called when the page is loaded to get the average rating of the game
    getaveragerating();
  });