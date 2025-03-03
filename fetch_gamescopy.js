document.addEventListener("DOMContentLoaded", function () {
    const gameGrid = document.querySelector(".games-grid");

    fetch("fetch_games.php")
        .then(response => response.json())
        .then(games => {
            gameGrid.innerHTML = "";
            games.forEach(game => {
                const gameElement = document.createElement("div");
                gameElement.classList.add("game-card");
                gameElement.innerHTML = `
                     <a href="gamedetails.html?game_id=${game.game_id}">
                    <img src="${game.cover || 'img/placeholder.png'}" alt="${game.title}">
                    <p class="game-title">${game.title}</p>
                `;
                gameGrid.appendChild(gameElement);
            });
        })
        .catch(error => console.error("Error fetching games:", error));
});



// document.addEventListener("DOMContentLoaded", function () {
//     const gamesGrid = document.querySelector(".games-grid");


//     fetch("sever.php")
//         .then(response => response.json())
//         .then(data => {
//             if (data.error) {
//                 console.error(data.error);
//                 gamesGrid.innerHTML = `<p>Error fetching games: ${data.error}</p>`;
//                 return;
//             }

//             gamesGrid.innerHTML = "";


//             data.forEach(game => {
//                 const imageUrl = game.cover
//                     ? `https://images.igdb.com/igdb/image/upload/t_cover_big/${game.cover.image_id}.jpg`
//                     : "img/Cyberpunk_2077_box_art.jpg";

//                 const gameCard = `
//                     <div class="game-card">
//                         <a href="gamedetails.html?api_id=${game.id}">
//                             <img src="${imageUrl}" alt="${game.name}">
//                             <p class="game-title">${game.name}</p>
//                         </a>
//                     </div>
//                 `;
//                 gamesGrid.insertAdjacentHTML("beforeend", gameCard);
//             });
//         })
//         .catch(error => {
//             console.error("Error:", error);
//             gamesGrid.innerHTML = `<p>Error fetching games.</p>`;
//         });
// });
