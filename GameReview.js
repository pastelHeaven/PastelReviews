let scrollContainer = document.querySelector('.gallery');
let back = document.getElementById('back');
let next = document.getElementById('next');


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
