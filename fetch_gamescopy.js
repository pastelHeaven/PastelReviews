// This file fetches game data from the  and database and displays it in a grid format on the webpage.


document.addEventListener("DOMContentLoaded", function () {
    const gameGrid = document.querySelector(".games-grid");

    // This script fetches game data from a PHP server script and displays it in a grid format on the webpage.
    fetch("fetch_games.php")
        .then(response => response.json())
        .then(games => {

            gameGrid.innerHTML = "";

            // this creates the game cards and adds them to the game grid
            games.forEach(game => {
                const gamelist = document.createElement("div");
                gamelist.classList.add("game-card");
                gamelist.innerHTML = `
                     <a href="gamedetails.html?game_id=${game.game_id}">
                    <img src="${game.cover || 'img/placeholder.png'}" alt="${game.title}">
                    <p class="game-title">${game.title}</p>
                `;
                // this adas each of the game card to the grid
                gameGrid.appendChild(gamelist);
            });
        })
        
        // this catches any errors that occur during the fetch process and logs them to the console
        .catch(error => console.error("Error fetching games:", error));
});

