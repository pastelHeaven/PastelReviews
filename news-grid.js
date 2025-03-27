//thsi si quide simular to what i did for my game grid the only diffrent was the async function fetchNews() but im adding the api data to my
// news grid
document.addEventListener("DOMContentLoaded", function () {
    const API_URL = "https://mmo-games.p.rapidapi.com/latestnews"; // mmo games news API URL
    const API_KEY = "21ddba5682msh29223c324433019p1a53fajsn2b5a3606d827";

    async function fetchNews() {
        try {
            const response = await fetch(API_URL, {
                method: "GET",
                headers: {
                    "X-RapidAPI-Key": API_KEY,
                    "X-RapidAPI-Host": "mmo-games.p.rapidapi.com"
                }
            });

            if (!response.ok) {
                throw new Error("Failed to fetch news data");
            }

            const data = await response.json();
            displayNews(data);
        } catch (error) {
            console.error("Error fetching news:", error);
        }
    }

    function displayNews(newsData) {
        if (!newsData || newsData.length === 0) return;

        console.log(newsData);

        const mainNews = newsData[0]; 
        document.getElementById("main-news-img").src = mainNews.main_image;
        document.getElementById("main-news-title").textContent = mainNews.title;
        document.getElementById("main-news-summary").textContent = mainNews.short_description;
      
        document.getElementById("main-news-card").addEventListener("click", function () {
            window.location.href = `newsdetails.html?news_id=${mainNews.id}`;
        });
    

        // Populate the news grid
        const newsGrid = document.getElementById("news-grid");
        newsGrid.innerHTML = ""; // Clear previous content

        newsData.slice(1).forEach(article => {
            const newsItem = document.createElement("div");
            newsItem.classList.add("news-card");

            newsItem.innerHTML = `
                <img src="${article.thumbnail}" alt="News Image">
                <div class="news-content">
                    <h3 class="news-title">${article.title}</h3>
                    <p class="news-summary">${article.short_description}</p>
                </div>
            `;

            newsItem.addEventListener("click", function () {
                window.location.href = `newsdetails.html?news_id=${article.id}`;
            });

            newsGrid.appendChild(newsItem);
        });
    }

    fetchNews();
});
