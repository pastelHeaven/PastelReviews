// This file gets and displays news details based on the news ID passed in the URL parameters.
// It uses the mmo-games API to retrieve the news data and dynamically creates HTML elements to show the news information.
// It also handles errors and displays appropriate messages if the news is not found or if there are issues with the API request.
// This script fetches and displays news details based on the news ID passed in the URL parameters.

document.addEventListener("DOMContentLoaded", function () {
    const API_URL = "https://mmo-games.p.rapidapi.com/latestnews"; 
    const API_KEY = "21ddba5682msh29223c324433019p1a53fajsn2b5a3606d827";

    const urlParams = new URLSearchParams(window.location.search);
    const newsId = urlParams.get("news_id");

    // if (!newsId) {
    //     document.getElementById("news-details").innerHTML = "<p>News not found.</p>";
    //     return;
    // }

    // this uses async function to fetch the news details from the API and display them on the page
    async function getnewsdetails() {
        try {
            // the await fetch() method is used to make an API request to the specified URL and retrieve the news data
            const response = await fetch(API_URL, {
                method: "GET",
                headers: {
                    "X-RapidAPI-Key": API_KEY,
                    "X-RapidAPI-Host": "mmo-games.p.rapidapi.com"
                }
            });
            const newsdata = await response.json();
            const article = newsdata.find(item => item.id == newsId);

            // if (!article) {
            //     document.getElementById("news-details").innerHTML = "<p>News not found.</p>";
            //     return;
            // }

            displayNewsdetails(article);
        } catch (error) {
            console.error("Error fetching news details:", error);
            document.getElementById("news-details").innerHTML = "<p>Failed to load news details.</p>";
        }
    }

    function displayNewsdetails(article) {

        // this function is used to display the news details on the page
        const titleElement = document.getElementById("news-title");
        const imgElement = document.getElementById("news-img");
        const introElement = document.getElementById("news-intro");
        const urlElement = document.getElementById("news-url");

        if (titleElement) titleElement.textContent = article.title;
        if (imgElement) imgElement.src = article.main_image || article.thumbnail;
        if (introElement) {
         
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = article.article_content || "No content available.";
    
     
            tempDiv.querySelectorAll("img").forEach(img => {
                if (img.src === imgElement.src) {
                    img.remove(); // thsi remove duplicate images as in teh api there have been 2 images added to the article
                }
            });
    
            introElement.innerHTML = tempDiv.innerHTML;
        }
    
        if (urlElement) urlElement.href = article.article_url;
    }
    

    getnewsdetails();
});
