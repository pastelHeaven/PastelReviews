document.addEventListener("DOMContentLoaded", function () {
    const API_URL = "https://mmo-games.p.rapidapi.com/latestnews"; 
    const API_KEY = "21ddba5682msh29223c324433019p1a53fajsn2b5a3606d827";

    //Get the news_id from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const newsId = urlParams.get("news_id");

    if (!newsId) {
        document.getElementById("news-details").innerHTML = "<p>News not found.</p>";
        return;
    }

    async function fetchNewsDetails() {
    

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

            const newsData = await response.json();
            const article = newsData.find(item => item.id == newsId);

            if (!article) {
                document.getElementById("news-details").innerHTML = "<p>News not found.</p>";
                return;
            }

            displayNewsDetails(article);
        } catch (error) {
            console.error("Error fetching news details:", error);
            document.getElementById("news-details").innerHTML = "<p>Failed to load news details.</p>";
        }
    }

    function displayNewsDetails(article) {
        const titleElement = document.getElementById("news-title");
        const imgElement = document.getElementById("news-img");
        const introElement = document.getElementById("news-intro");
        const urlElement = document.getElementById("news-url");
    
        if (titleElement) titleElement.textContent = article.title;
    
        // Set the main image only once
        if (imgElement) imgElement.src = article.main_image || article.thumbnail;
    
        if (introElement) {
            // Create a temporary element to filter content
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = article.article_content || "No content available.";
    
            // Remove any image inside article_content if it matches the main image
            tempDiv.querySelectorAll("img").forEach(img => {
                if (img.src === imgElement.src) {
                    img.remove(); // Remove duplicate images
                }
            });
    
         
            // pdate the page with cleaned content
            introElement.innerHTML = tempDiv.innerHTML;
        }
    
        if (urlElement) urlElement.href = article.article_url;
    }
    

    fetchNewsDetails();
});
