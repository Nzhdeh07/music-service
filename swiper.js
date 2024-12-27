// Адаптивный слайдер с навигацией и динамическим скрытием кнопок
new Swiper("#productSwiper", {
    slidesPerView: 1.5,
    spaceBetween: 10,
    breakpoints: {
        0: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1400: {
            slidesPerView: 4,
        },
        1600: {
            slidesPerView: 5,
        },
        1800: {
            slidesPerView: 6,
        },
        1920: {
            slidesPerView: 6,
        },
    },

    navigation: {
        nextEl: "#swiper-button-next",
        prevEl: "#swiper-button-prev",
    },
    on: {
        init: function () {
            // Скрыть prev кнопку при инициализации
            document.getElementById("swiper-button-prev").style.display = "none";
        },
        slideChange: function () {
            // Показывать или скрывать кнопки в зависимости от позиции слайда
            document.getElementById("swiper-button-prev").style.display = this.isBeginning ? "none" : "block";
            document.getElementById("swiper-button-next").style.display = this.isEnd ? "none" : "block";
        },
    },
});

new Swiper("#similarProductSwiper", {
    slidesPerView: 1.5,
    spaceBetween: 10,
    breakpoints: {
        0: {
            slidesPerView: 1.5,
        },
        768: {
            slidesPerView: 3,
        },
        1400: {
            slidesPerView: 4,
        },
        1600: {
            slidesPerView: 5,
        },
        1800: {
            slidesPerView: 6,
        },
        1920: {
            slidesPerView: 6,
        },
    },

    navigation: {
        nextEl: "#similarProduct-next",
        prevEl: "#similarProduct-prev",
    },
    on: {
        init: function () {
            // Скрыть prev кнопку при инициализации
            document.getElementById("similarProduct-prev").style.display = "none";
        },
        slideChange: function () {
            // Показывать или скрывать кнопки в зависимости от позиции слайда
            document.getElementById("similarProduct-prev").style.display = this.isBeginning ? "none" : "block";
            document.getElementById("similarProduct-next").style.display = this.isEnd ? "none" : "block";
        },
    },
});


// Бесконечно вращающийся слайдер брендов с клонированием слайдов
document.addEventListener("DOMContentLoaded", function () {
    const serviceSlider = document.querySelector('.brand-slider .swiper-wrapper');

    let slides = serviceSlider.querySelectorAll('.swiper-slide');
    const minSlides = 15;

    if (slides.length < minSlides) {
        const slidesArray = Array.from(slides);
        while (serviceSlider.children.length < minSlides) {
            slidesArray.forEach(slide => {
                if (serviceSlider.children.length < minSlides) {
                    const clone = slide.cloneNode(true);
                    serviceSlider.appendChild(clone);
                }
            });
        }
    }

    new Swiper('.brand-slider', {
        breakpoints: {
            0: {
                slidesPerView: 1.5,
            },
            768: {
                slidesPerView: 4,
            },
            1400: {
                slidesPerView: 5,
            },
            1600: {
                slidesPerView: 6,
            },
            1800: {
                slidesPerView: 7,
            },
            1920: {
                slidesPerView: 9,
            },
        },
        spaceBetween: 0,
        loop: true,
        speed: 5000,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
        },
        freeMode: true,
        freeModeMomentum: false,
    });
});



// Адаптивный слайдер с навигацией и динамическим скрытием кнопок
new Swiper("#serviceSlider", {
    slidesPerView: 1.5,
    spaceBetween: 10,
    speed: 1000,
    breakpoints: {
        0: {
            slidesPerView: 1.5,
        },
        768: {
            slidesPerView: 3,
        },
        1400: {
            slidesPerView: 4,
        },
        1600: {
            slidesPerView: 5,
        },
        1800: {
            slidesPerView: 6,
        },
        1920: {
            slidesPerView: 6,
        },
    },

    navigation: {
        nextEl: "#service-next",
        prevEl: "#service-prev",
    },

    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    on: {
        init: function () {
            // Скрыть prev кнопку при инициализации
            document.getElementById("service-prev").style.display = "none";
        },
        slideChange: function () {
            // Показывать или скрывать кнопки в зависимости от позиции слайда
            document.getElementById("service-prev").style.display = this.isBeginning ? "none" : "block";
            document.getElementById("service-next").style.display = this.isEnd ? "none" : "block";
        },
    },
});
