//this gets the game from the fetch_games.php file and adds it to the index page, i used this to get the games from the database 
// and add them to the index page which is simular to what i did for the game grid
document.addEventListener("DOMContentLoaded", () => {
    fetch("fetch_games.php")
      .then(response => response.json())
      .then(data => {
        const gallery = document.querySelector(".gallery");
        gallery.innerHTML = ""; 
  
        let row1 = document.createElement("div");
        let row2 = document.createElement("div");
  
        data.slice(0, 10).forEach((game, index) => {
          const img = document.createElement("img");
          img.src = game.cover;
          img.alt = game.title;
          img.style.cursor = "pointer";
          img.addEventListener("click", () => {
            window.location.href = `gamedetails.html?game_id=${game.game_id}`;
          });
  
          const span = document.createElement("span");
          span.appendChild(img);
  
          if (index < 5) {
            row1.appendChild(span);
          } else {
            row2.appendChild(span);
          }
        });
  
        gallery.appendChild(row1);
        gallery.appendChild(row2);
      })
      .catch(error => {
        console.error("Failed to fetch games:", error);
      });
  });
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


// This code fetches the latest news articles from the MMO Games API and displays them on the page in a vertical card format, simular to 
// what i did in the news-grid.js file.
const API_URL = "https://mmo-games.p.rapidapi.com/latestnews";
const API_KEY = "21ddba5682msh29223c324433019p1a53fajsn2b5a3606d827";

async function getNews() {
  try {
    const response = await fetch(API_URL, {
      method: "GET",
      headers: {
        "X-RapidAPI-Key": API_KEY,
        "X-RapidAPI-Host": "mmo-games.p.rapidapi.com"
      }
    });

    const newsData = await response.json();
    const newsContainer = document.querySelector(".Virtcal-card");
    
    // Limit to top 4 news items
    newsData.slice(0, 4).forEach(article => {
      const cardItem = document.createElement("div");
      cardItem.classList.add("card-item");

      cardItem.innerHTML = `
        <img class="index-img" src="${article.thumbnail}" alt="${article.title}">
        <div class="text-content">
          <h3 class="h3-content">${article.title}</h3>
          <p class="p-content">${article.short_description}</p>
        </div>
      `;

      // Add click redirect to news details 
      cardItem.addEventListener("click", () => {
        window.location.href = `newsdetails.html?news_id=${article.id}`;
      });

      newsContainer.appendChild(cardItem);

        // Add a horizontal line between cards
      const hr = document.createElement("hr");
      hr.classList.add("card-hr");
      newsContainer.appendChild(hr);
    });

  } catch (error) {
    console.error("Failed to fetch news:", error);
  }
}

// Load on page load
document.addEventListener("DOMContentLoaded", getNews);

document.addEventListener("DOMContentLoaded", () => {
    fetch("latest_reveiws.php")
      .then(response => response.json())
      .then(data => {
        const reviewContainer = document.querySelector(".review-grid");
        reviewContainer.innerHTML = ""; // Clear existing reviews
  
        data.slice(0, 4).forEach(review => {
          const stars = "★".repeat(Math.round(review.rating)) + "☆".repeat(5 - Math.round(review.rating));
          const reviewItem = document.createElement("div");
          reviewItem.classList.add("review-item");
  
          reviewItem.innerHTML = `
            <img class="profile-pic" src="img/—Pngtree—gray avatar placeholder_6398267.png" alt="User Profile Picture">
            <div class="review-content">
              <div class="review-header">
                <span class="reviewer-name">${review.username}</span>
                <span class="review-rating">${stars}</span>
                <span class="reviewed-game">reviewed ${review.platform}</span>
              </div>
              <p class="review-text">${review.comment}</p>
              <div class="review-interactions">
                <span class="likes">0 Likes</span>
                <span class="comments">0 Comments</span>
              </div>
            </div>
          `;
  
          reviewContainer.appendChild(reviewItem);
        });
      })
      .catch(error => {
        console.error("Failed to load reviews:", error);
      });
  });