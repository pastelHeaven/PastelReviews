//
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get("game_id");

    // if (gameId) {
    //     document.getElementById("game-id").value = gameId;
    // } else {
    //     document.body.innerHTML = "<p>Error: Game ID not found.</p>";
    // }

    // Define goBackToGameDetails Function
    function goBackToGameDetails() {
        const urlParams = new URLSearchParams(window.location.search);
        const gameId = urlParams.get("game_id");

        if (gameId) {
            window.location.href = `gamedetails.html?game_id=${gameId}`;
        } else {
            alert("Error: Game ID not found.");
        }
    }

    //Adding an event Listener to Back Button so that it will connect with the ids when its clicked
    const backButton = document.querySelector(".back-btn");
    if (backButton) {
        backButton.addEventListener("click", goBackToGameDetails);
    }
    const reviewForm = document.getElementById("review-form");



    if (reviewForm) {
        reviewForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Stops default form submission which was causing GET request

            const formData = new FormData(reviewForm);

            fetch("test.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Expecting JSON response
            .then(data => {
                alert(data.message); // Show success/error message
                if (data.success) {
                    reviewForm.reset(); // Reset form if successful
                }
            })
            .catch(error => console.error("Error submitting review:", error));
        });
    }
});
