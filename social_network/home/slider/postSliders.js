import { initSlider } from "./initSlider.js";

document.addEventListener("DOMContentLoaded", function () {
    const posts = document.querySelectorAll(".post");
    posts.forEach((post) => initSlider(post.querySelector(".slider")));
});
