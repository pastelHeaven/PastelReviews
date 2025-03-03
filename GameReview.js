let scrollContainer = document.querySelector('.gallery');
let back = document.getElementById('back');
let next = document.getElementById('next');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
let currentPage = 1;
const totalPages = 5728; // Set to the total number of pages

scrollContainer.addEventListener("wheel", (evt) => {
    evt.preventDefault();
    scrollContainer.scrollLeft += evt.deltaY;
    scrollContainer.style.scrollBehavior = 'auto';
});

next.addEventListener("click", ()=>{
    scrollContainer.style.scrollBehavior = 'smooth';
    scrollContainer.scrollLeft += 1150;
});

back.addEventListener("click", ()=>{
    scrollContainer.style.scrollBehavior = 'smooth';
    scrollContainer.scrollLeft -= 1150;
});

function updatePagination() {
    const buttons = document.querySelectorAll('.pagination-button');
    buttons.forEach(button => button.classList.remove('active'));
    buttons[currentPage - 1].classList.add('active');
    prevButton.disabled = currentPage === 1;
    nextButton.disabled = currentPage === totalPages;
}

prevButton.addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        updatePagination();
    }
});

nextButton.addEventListener('click', () => {
    if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
    }
});

updatePagination();


