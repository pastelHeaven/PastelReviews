// This script fetches game data from a PHP server script and displays it in a grid format on the webpage.
// It uses the igbd API to retrieve data and dynamically creates HTML elements to show the game information.
// ive stop uisng this code for my game grid and make a copy called fetch_gamescode.js as ive ran into an 3rd party api error
//  as igbd has changed its api and i need to update my code to work with my databse but here is my old code for reference

document.addEventListener("DOMContentLoaded", function () {
    const gamesGrid = document.querySelector(".games-grid");

    // this is uses the server.php (apologies for the spelling mistake), as this file connected to the igbd api 
    // and fetches the data from the igbd api, this is then used to display the games on the game grid
    fetch("sever.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                gamesGrid.innerHTML = `<p>Error fetching games: ${data.error}</p>`;
                return;
            }

            gamesGrid.innerHTML = "";
            
            // this creates the game cards and adds them to the game grid
            data.forEach(game => {
                const imageUrl = game.cover
                    ? `https://images.igdb.com/igdb/image/upload/t_cover_big/${game.cover.image_id}.jpg`
                    : "img/Cyberpunk_2077_box_art.jpg"; // this a fallback image

                const gameCard = `
                    <div class="game-card">
                        <a href="gamedetails.html?game_id=${game.id}">
                            <img src="${imageUrl}" alt="${game.name}">
                            <p class="game-title">${game.name}</p>
                        </a>
                    </div>
                `;
                gamesGrid.insertAdjacentHTML("beforeend", gameCard);
            });
        })
        .catch(error => {
            console.error("Error:", error);
            gamesGrid.innerHTML = `<p>Error fetching games.</p>`;
        });
});
