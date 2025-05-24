import { initSlider } from "./slider/initSlider.js";

document.addEventListener("DOMContentLoaded", () => {
    const overlay = document.querySelector(".overlay");
    const overlaySlider = overlay.querySelector(".slider");
    const overlayCounter = overlay.querySelector(".overlay__counter");
    overlay.querySelector(".overlay__close").onclick = closeOverlay;

    const posts = document.querySelectorAll(".post");

    posts.forEach((post) => {
        const slides = post
            .querySelector(".slider")
            .querySelectorAll(".slider__image");
        const imgs = Array.from(slides);
        slides.forEach((img) => {
            img.addEventListener("click", () => {
                const index = imgs.indexOf(img);
                openOverlay(
                    imgs.map((i) => i.src),
                    index
                );
            });
        });
    });

    function openOverlay(images, index) {
        overlay.classList.add("show");
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") closeOverlay();
        });
        document.body.style.overflow = "hidden";
        fillSlider(images);
        initSlider(overlaySlider, index, overlayCounter);
    }

    function fillSlider(images) {
        images.forEach((src) => {
            const slide = document.createElement("div");
            slide.className = "slider__slide";
            slide.innerHTML = `<img src="${src}" class="slider__image">`;
            overlaySlider.appendChild(slide);
        });
    }

    function closeOverlay() {
        overlaySlider
            .querySelectorAll(".slider__slide")
            .forEach((slide) => overlaySlider.removeChild(slide));

        overlay.classList.remove("show");
        document.removeEventListener("keydown", closeOverlay);
        document.body.style.removeProperty("overflow");
    }
});
