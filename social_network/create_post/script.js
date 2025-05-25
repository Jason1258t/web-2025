import { initSlider } from "../home/slider/initSlider.js";

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.body.querySelector(".slider");
    const counter = slider.querySelector(".slider__counter");
    const input = document.getElementById("file-input");
    const confirm = document.getElementById("confirm");
    const addZone = document.querySelector(".images-container__add");

    const description = document.getElementById("description");
    input.addEventListener("change", handleFiles);

    const [addFirst, add] = [
        document.getElementById("add-first-image"),
        document.getElementById("add-image"),
    ];

    let images = [];

    addFirst.onclick = () => input.click();
    add.onclick = () => input.click();
    update();

    function handleFiles(e) {
        const files = e.target.files;
        images = [...images, ...files];
        removeImages();
        fillImages();
        update();
    }

    function removeImages() {
        slider
            .querySelectorAll(".slider__slide")
            .forEach((slide) => slider.removeChild(slide));
    }

    function fillImages() {
        images.forEach((file) => {
            const src = URL.createObjectURL(file);
            const slide = document.createElement("div");
            slide.className = "slider__slide";
            slide.innerHTML = `<img src="${src}" class="slider__image">`;
            slider.appendChild(slide);
        });
    }

    function update() {
        const slides = slider.querySelectorAll(".slider__slide");
        slider.style.display = slides.length ? "block" : "none";
        addZone.style.display = slides.length ? "none" : "block";
        initSlider(slider, slides.length - 1, counter);
        confirm.classList.toggle("active", slides.length > 0);
        confirm.onclick = slides.length ? create : () => {};
    }

    async function create() {
        const json = {
            user_id: 1, 
            description: description.value.trim(),
        };

        const formData = new FormData();
        formData.append("json", JSON.stringify(json));

        images.forEach((file) => {
            formData.append("images[]", file);
        });

        try {
            const res = await fetch("../data/add_post.php", {
                method: "POST",
                body: formData,
            });

            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.error || "Unknown error");
            }

            document.querySelector(".form").style.display = "none";
            document.querySelector(".success-message").textContent =
                "Пост успешно сохранен!";
            document.querySelector(".success-message").style.display = "block";
        } catch (err) {
            alert("Ошибка: " + err.message);
        }
    }
});
