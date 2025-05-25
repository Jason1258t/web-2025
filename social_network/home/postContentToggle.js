document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".post").forEach((post) => {
        const textEl = post.querySelector(".post__text");
        const toggleBtn = post.querySelector(".post__content-toggle");
        toggleBtn.hidden = true;
        if (!textEl) return;

        const [fullHeight, clampedHeight] = getSizes(textEl);
        const isOverflowing = fullHeight > clampedHeight;
        
        if (isOverflowing) {
            toggleBtn.hidden = false;
            toggleBtn.addEventListener("click", () => {
                const expanded = textEl.classList.toggle("expanded");
                toggleBtn.textContent = expanded ? "свернуть" : "ещё...";
            });
        }
    });
});

function getSizes(textEl) {
    const clampedHeight = textEl.getBoundingClientRect().height;
    const fullHeight = textEl.scrollHeight;

    return [fullHeight, clampedHeight];
}