document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get("game_id");
    
    const averageRatingElement = document.querySelector(".rating-score");
  
    async function fetchAverageRating() {
      try {
        const response = await fetch(`avg_rating.php?game_id=${gameId}`);
        if (!response.ok) throw new Error("Failed to fetch average rating");
  
        const data = await response.json();
        if (data.average_rating) {
          averageRatingElement.textContent = data.average_rating;
        } else {
          averageRatingElement.textContent = "No ratings yet";
        }
      } catch (error) {
        console.error(error);
        averageRatingElement.textContent = "Error loading rating";
      }
    }
  
    fetchAverageRating();
  });