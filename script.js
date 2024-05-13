window.onload = function() {
    adjustBottom();
    window.addEventListener('resize', adjustBottom);
}

function adjustBottom() {
    const spinnerContainer = document.querySelector('.spinner-container');
    const parentWidth = spinnerContainer.parentElement.offsetWidth;
    const bottomPosition = -0.55 * parentWidth;
    spinnerContainer.style.setProperty('--bottom', `${bottomPosition}px`);
}

// const textArea = document.querySelector("textarea");
// textArea.addEventListener("keyup", e =>{
//     textArea.style.height = '15%';
//     let height = e.target.scrollHeight;
//     console.log(height);
//     textArea.style.height = `${height}px`;
// });