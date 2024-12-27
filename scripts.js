document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-subcategories');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const categoryWrapper = this.closest('.category');
            const subcategories = categoryWrapper.querySelector('.subcategories');

            if (subcategories) {
                subcategories.classList.toggle('hidden');

                // Заменяем иконку на крестик или другой символ в зависимости от состояния
                if (subcategories.classList.contains('hidden')) {
                    this.innerHTML = `
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.0059 8.50513V12.0051M12.0059 12.0051V15.5051M12.0059 12.0051H8.50586M12.0059 12.0051H15.5059"
                                  stroke="black" stroke-opacity="0.8" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.00586 12.0051C3.00586 7.03456 7.0353 3.00513 12.0059 3.00513C16.9764 3.00513 21.0059 7.03456 21.0059 12.0051C21.0059 16.9757 16.9764 21.0051 12.0059 21.0051C7.0353 21.0051 3.00586 16.9757 3.00586 12.0051Z"
                                  stroke="black" stroke-opacity="0.8" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    `;
                } else {
                    this.innerHTML = `
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M16 8L8 16M8 8L16 16" stroke="black" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-opacity="0.8" stroke-width="1.5"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="24" height="24" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    `;
                }
            }
        });
    });
});

// module/catalog Раскрывает категории, если их больше 5
document.addEventListener('DOMContentLoaded', function () {
    const showAllButtons = document.querySelectorAll('.show-all-button');
    showAllButtons.forEach(button => {
        button.addEventListener('click', function () {
            const subcategoryItems = button.parentElement.querySelectorAll('.hidden');
            subcategoryItems.forEach(item => item.classList.remove('hidden'));
            button.remove();
        });
    });
});

jQuery(document).ready(function ($) {
    function checkTextBlocks() {
        $('.text-hide .text-block').each(function () {
            var $this = $(this);
            var maxHeight = 170;

            $this.css('max-height', '');
            $this.css('overflow', '');
            $this.removeClass('expanded');

            if ($this.outerHeight() > maxHeight) {
                $this.css({
                    'max-height': maxHeight + 'px',
                    'overflow': 'hidden',
                    'position': 'relative',
                });

                var readMoreBtn = $this.closest('.text-hide').next('.read-more-container').find('.read-more-button');
                const img = document.querySelector(".about-us-img");

                readMoreBtn.on('click', function () {
                    if ($this.hasClass('expanded')) {
                        $this.removeClass('expanded');
                        $this.addClass('text-block');
                        img.classList.remove('hfull');
                        $this.css('max-height', maxHeight + 'px');
                        $(this).find('p').text('Читать далее');
                    } else {
                        $this.addClass('expanded');
                        $this.removeClass('text-block');
                        img.classList.add('hfull');
                        $this.css('max-height', 'none');
                        $(this).find('p').text('Скрыть');
                    }
                });
            } else {
                $this.closest('.text-hide').next('.read-more-container').hide();
            }
        });
    }

    checkTextBlocks();

    let lastWindowWidth = jQuery(window).width();
    jQuery(window).on('resize', function () {
        let currentWindowWidth = jQuery(window).width();
        if (currentWindowWidth !== lastWindowWidth) {
            checkTextBlocks();
            lastWindowWidth = currentWindowWidth;
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    Fancybox.bind('[data-fancybox="gallery"]', {
        // Настройки Fancybox (например, чтобы показывать стрелки и навигацию)
        infinite: true,
        Thumbs: {
            autoStart: true,
        },
        Toolbar: {
            display: {
                left: [],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW", "flipX", "flipY"],
                right: ["close"],
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    Fancybox.bind('[data-fancybox="gallery-document"]', {
        // Настройки Fancybox (например, чтобы показывать стрелки и навигацию)
        infinite: true,
        Thumbs: {
            autoStart: true,
        },
        Toolbar: {
            display: {
                left: [],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW", "flipX", "flipY"],
                right: ["close"],
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.accordion-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const content = this.closest('div').nextElementSibling;
            content.classList.toggle('show');

            const button = toggle.querySelector(".accordion-button");
            const isExpanded = button.getAttribute("aria-expanded") === "true";
            button.setAttribute("aria-expanded", !isExpanded);
            const img = button.querySelector(".toggle-icon");
            img.classList.toggle("rotate", !isExpanded);
        });
    });
});


// Инициализация Fancybox
Fancybox.bind('[data-fancybox]', {
    buttons: [
        "zoom",
        "close",
        "fullscreen",
    ],
    zoom: {
        enabled: true,
        duration: 300,
    },
    transitionEffect: "tube",
});


// Настройка Fancybox
Fancybox.bind('[data-fancybox="search-bar"]', {
    closeButton: false, // Отключаем кнопку закрытия
    clickOutside: 'close', // Закрытие кликом за пределами
    on: {
        reveal: (fancybox) => {
            const searchInput = fancybox.container.querySelector('#voice-search');
            if (searchInput) {
                searchInput.focus();
            }
        }
    }
});

Fancybox.bind('[data-fancybox="price"]', {});
Fancybox.bind('[data-fancybox="buy"]', {});
Fancybox.bind('[data-fancybox="menu"]', {});
Fancybox.bind('[data-fancybox="modal-search"]', {});


document.querySelectorAll('.buy-button').forEach(button => {
    button.addEventListener('click', () => {
        // Найти форму внутри элемента с ID buy
        const form = document.querySelector('#buy form');

        // Устанавливаем значения полей в найденной форме
        form.querySelector('#productPrice').value = button.dataset.price;
        form.querySelector('#productTitle').value = button.dataset.ptitle;
        const span = form.querySelector('#prTitle'); // Находим <span> по ID
        span.textContent = button.dataset.ptitle;
        form.querySelector('#productUrl').value = button.dataset.url;
    });
});

document.querySelectorAll('.price-button').forEach(button => {
    button.addEventListener('click', () => {
        // Найти форму внутри элемента с ID buy
        const form = document.querySelector('#price form');
        form.querySelector('#productTitle').value = button.dataset.ptitle;
        const span = form.querySelector('#prTitle'); // Находим <span> по ID
        span.textContent = button.dataset.ptitle;
        form.querySelector('#productUrl').value = button.dataset.url;
    });
});

$(document).ready(function () {
    $('form:not([action])').on('submit', function (e) {
        e.preventDefault();
        console.log("Форма отправлена");
        const form = $(this);

        const inputError = $(form).find('.error-message').length === 0;
        console.log("inputError:", inputError);
        if (inputError) {
            console.log("Начало отправки формы");
            sendForm(form);
        }
    });

    function sendForm(form) {
        var arr = form.serializeArray(),
            obj = {};
        $.each(arr, function (indx, el) {
            obj[el.name] ? obj[el.name].push(el.value) : (obj[el.name] = [el.value]);
        });

        console.log("Отправка данных:", obj);
        $.ajax({
            type: "POST",
            url: `${dirURL}/send-order.php`,
            data: obj
        }).done(function () {
            const successMessage = document.querySelector('.successMessage');
            console.log("Форма успешно отправлена");
            setTimeout(() => {
                form.trigger("reset");
                $('.successMessage').fadeIn();
                setTimeout(() => {
                    $('.successMessage').fadeOut();
                }, 3000);
            }, 1000);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Ошибка отправки:", textStatus, errorThrown);
        });
    }
});

// Код скрывает/показывает элементы при прокрутке страницы
$(document).ready(function () {
    const header = $('#header-mobile');
    const search = $('#search');
    const men = $('#men');
    let isHidden = false;

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 100 && !isHidden) {
            header.addClass('scroll');
            header.addClass('border-gray-300');
            isHidden = true;
        } else if ($(window).scrollTop() <= 45 && isHidden) {
            header.removeClass('border-gray-300');
            header.removeClass('scroll');
            isHidden = false;
        }
    });
});


let totalPrice = 0;

function cleanOldItems(cart) {
    const twoHours = 2 * 60 * 60 * 1000;
    const currentTime = Date.now();

    for (const productId in cart) {
        if (cart.hasOwnProperty(productId)) {
            const item = cart[productId];
            if (currentTime - item.timestamp > twoHours) {
                delete cart[productId];
            }
        }
    }

    sessionStorage.setItem("cart", JSON.stringify(cart));
    getCart();
}

function addToCart(productId, productName, productPrice, discountPrice, productImage, productUrl) {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};
    const currentTime = Date.now();

    cleanOldItems(cart);

    if (cart[productId]) {
        cart[productId].quantity += 1;
    } else {
        cart[productId] = {
            name: productName,
            price: productPrice,
            discountPrice: discountPrice,
            image: productImage,
            quantity: 1,
            url: productUrl,
            timestamp: currentTime,
        };
    }
    sessionStorage.setItem("cart", JSON.stringify(cart));

    getCart();
}

// Проверка корзины на старые товары каждые 2 минуты
setInterval(() => {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};
    cleanOldItems(cart);
}, 30 * 60 * 1000);

function changeQuantity(productId, change) {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};

    if (cart[productId]) {
        cart[productId].quantity += change;
        // Убедимся, что количество не отрицательное
        if (cart[productId].quantity < 1) {
            cart[productId].quantity = 1; // Минимальное количество 1
        }
        sessionStorage.setItem("cart", JSON.stringify(cart));
        getCart(); // Обновляем отображение корзины
    }
}

function removeFromCart(productId) {
    let cartContentDiv = document.getElementById("cart-content");
    if (!cartContentDiv) {
        console.error("Элемент с ID 'cart-content' не найден.");
        return;
    }

    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};


    if (cart[productId]) {
        delete cart[productId];
    }
    sessionStorage.setItem("cart", JSON.stringify(cart));
    getCart();
}

function getCart() {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};
    let cartContentDiv = document.getElementById("cart-content");
    let cartItems = [];
    totalPrice = 0; // Сброс общей суммы
    let quantity = 0;

    for (let productId in cart) {
        let item = cart[productId];
        let price = item.discountPrice ? item.discountPrice : item.price;
        let url = item.url;
        let itemTotalPrice = price * item.quantity; // Подсчет цены для текущего товара
        totalPrice += itemTotalPrice; // Добавляем цену текущего товара к общей сумме
        quantity += +item.quantity;

        cartItems.push(`
            <div class="grid gap-3" style="grid-template-columns: 1fr 3fr;">
            <a href="${url}">
                <img  class="link w-full h-full object-cover" src="${item.image}" alt="${item.name}">
                </a>
                <div class="flex flex-col gap-2">
                  <a href="${url}">
                    <div class="link font-medium text-sm leading-5">${item.name}</div>
                                  </a>
                    <div id="price-${productId}" class="flex gap-2.5 items-center font-medium leading-5">
                        ${price} BYN
                         ${item.discountPrice ? `
                    <div class="font-medium text-sm leading-5 line-through text-customGreen-dark" style="text-decoration: line-through;">
                        ${item.price} BYN
                    </div>
                ` : ''}
                         
                    </div>
                    <div class="flex justify-between gap-3 items-center">
                        <div class="flex gap-3 items-center">
                           <button style="width: 28px; height: 28px" onclick="changeQuantity('${productId}', -1)" class="link p-2 bg-customGreen rounded-md overflow-hidden text-white flex items-center justify-center text-xl relative">
  <img style="width: 12px; height: 12px; position: absolute;" src="https://pandabox.digitalgoweb.com/wp-content/themes/talpa/img/icons-minus.png" alt="delete">
</button>

                            <span id="quantity-${productId}">${item.quantity}</span>
                <button style="width: 28px; height: 28px" onclick="changeQuantity('${productId}', +1)" class="link p-2 bg-customGreen rounded-md overflow-hidden text-white flex items-center justify-center text-xl relative">
  <img style="width: 12px; height: 12px; position: absolute;" src="https://pandabox.digitalgoweb.com/wp-content/themes/talpa/img/icons-plus.svg" alt="delete">
</button>
                        </div>
                        <button class="link" onclick="removeFromCart('${productId}')">
                            <img src="http://talpaservice.by/wp-content/themes/talpa/img/svg/delete.svg" alt="delete">
                        </button>
                    </div>
                </div>
            </div>
        `);
    }

    if (cartItems.length > 0) {
        cartContentDiv.innerHTML = cartItems.join('');
        document.getElementById("order-form").classList.remove('hidden');
    } else {
        cartContentDiv.innerHTML = 'Корзина пуста.';
        document.getElementById("order-form").classList.add('hidden');
    }

    if (document.getElementById("display-price-value")) {
        document.getElementById("display-price-value").innerText = totalPrice.toFixed(2);
    }

    if (document.getElementById("display-product-name")) {
        document.getElementById("display-product-name").innerText = cartItems.length > 0 ? "Ваши товары" : "Корзина пуста.";
    }

    const cartCountElements = document.querySelectorAll(".cart-count");
    cartCountElements.forEach((element) => {
        element.innerText = quantity;
    });

// Обновляем текст на кнопке "Заказать" с учетом общей суммы
    let orderButtonText = document.getElementById("order-button-text");
    if (orderButtonText) {
        orderButtonText.innerHTML = `Заказать на сумму ${totalPrice.toFixed(2)} рублей`;
    }


// Проверяем текущую версию Fancybox
    if (typeof Fancybox !== "undefined") {
        const fancyboxInstance = Fancybox.getInstance();
        if (fancyboxInstance) {
            fancyboxInstance.setContent(cartContentDiv.innerHTML);
        }
    } else if (typeof $ !== "undefined" && $.fancybox) {
        if ($.fancybox.getInstance()) {
            $.fancybox.getInstance().update();
        }
    }
}

getCart();

function clearCart() {
    sessionStorage.removeItem("cart");
    getCart();
}

jQuery(document).ready(function ($) {


    let originalPrice = 0;

    $('.order-button').on('click', function () {
        const productId = this.getAttribute('data-productId');
        const productName = this.getAttribute('data-ptitle');
        const productPrice = this.getAttribute('data-price');
        const discountPrice = this.getAttribute('data-discountPrice');
        const productImage = this.getAttribute('data-img');


        var productUrl = $(this).data('url');
        $('#product-name').val(productUrl);

        // Получаем цену продукта и сохраняем её в переменной
        originalPrice = parseFloat($(this).data('price'));
        $('#product-price').val(originalPrice.toFixed(2)); // Устанавливаем оригинальную цену
        $('#display-price-value').text(originalPrice.toFixed(2)); // Отображаем оригинальную цену

        addToCart(productId, productName, productPrice, discountPrice, productImage, productUrl);
        changeQuantity();
        getCart();
    });

});

document.getElementById('orderForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const submitButton = document.getElementById('submitButton');
    const formData = new FormData(this);

    // Получение корзины из sessionStorage
    let cart = JSON.parse(sessionStorage.getItem("cart")) || {};
    let totalPrice = 0; // Переменная для хранения общей стоимости заказа

    // Перебираем товары в корзине и добавляем их в FormData
    for (let productId in cart) {
        let item = cart[productId];
        formData.append('product_name[]', item.name); // Добавляем имя товара
        formData.append('product_quantity[]', item.quantity); // Добавляем количество товара
        formData.append('product_price[]', item.price); // Добавляем цену товара
    }
    // Добавляем общую цену в FormData
    formData.append('total_price', parseFloat(document.getElementById("display-price-value").innerText) || 0);

    fetch('<?php echo get_template_directory_uri(); ?>/send-order.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                submitButton.textContent = 'Заказ отправлен';
                submitButton.classList.remove('bg-rose-500', 'hover:bg-rose-600');
                submitButton.classList.add('bg-green-500', 'text-white');

                setTimeout(() => {
                    submitButton.textContent = 'Отправить заказ';
                    submitButton.classList.remove('bg-green-500');
                    submitButton.classList.add('bg-rose-500', 'hover:bg-rose-600');
                    document.getElementById('orderForm').reset();
                    document.querySelector('.f-button.is-close-btn').click();
                }, 1000);
            } else {
                alert('Ошибка при отправке заказа. Попробуйте еще раз.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Ошибка при отправке заказа. Попробуйте еще раз.');
        });
});


document.addEventListener('DOMContentLoaded', () => {
    const pagination = document.querySelector('.pagination');

    // Проверяем, есть ли у элемента `pagination` дочерние элементы
    if (pagination && pagination.children.length === 0) {
        pagination.classList.add('hidden');
    } else {
        pagination.classList.remove('hidden'); // Удаляем `hidden`, если элементы есть
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.buy-button').forEach(button => {
        button.addEventListener('click', function () {
            // Находим видимую кнопку корзины
            const visibleCartButton = Array.from(document.querySelectorAll('.cart-count')).find(button => {
                return button.offsetParent !== null; // Проверка на видимость элемента
            });

            if (!visibleCartButton) {
                console.error('Кнопка корзины не найдена!');
                return;
            }

            // Создаем анимационный круг
            const circle = document.createElement('div');
            circle.classList.add('cart-animation');

            // Получаем начальные координаты кнопки "Купить"
            const rectStart = button.getBoundingClientRect();
            circle.style.left = `${rectStart.left + rectStart.width / 2}px`;
            circle.style.top = `${rectStart.top + rectStart.height / 2}px`;

            // Добавляем круг в документ
            document.body.appendChild(circle);

            // Получаем целевые координаты кнопки корзины
            const cartRect = visibleCartButton.getBoundingClientRect();

            // Центр кнопки корзины
            const cartCenterX = cartRect.left + cartRect.width / 2;
            const cartCenterY = cartRect.top + cartRect.height / 2;

            // Центр кнопки "Купить"
            const startCenterX = rectStart.left + rectStart.width / 2;
            const startCenterY = rectStart.top + rectStart.height / 2;

            // Вычисляем смещение
            const targetX = cartCenterX - startCenterX;
            const targetY = cartCenterY - startCenterY;

            // Устанавливаем CSS-переменные
            circle.style.setProperty('--target-x', `${targetX}px`);
            circle.style.setProperty('--target-y', `${targetY}px`);


            // Удаляем круг после завершения анимации
            circle.addEventListener('animationend', () => {
                circle.remove();
            });
        });
    });
});


let isRecording = false; // Флаг для отслеживания состояния записи
let mediaRecorder; // Для сохранения экземпляра MediaRecorder
let audioChunks = []; // Для хранения записанных аудио данных

// Обработчик для кнопки записи
document.getElementById('recording-btn').addEventListener('click', () => {
    const button = document.getElementById('recording-btn');

    if (!isRecording) {
        // Начало записи
        navigator.mediaDevices.getUserMedia({audio: true})
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    console.log('Запись завершена');

                    const audioBlob = new Blob(audioChunks, {type: 'audio/wav'});
                    const audioFile = new File([audioBlob], 'audio_recording.wav', {type: 'audio/wav'});

                    // Загружаем файл на сервер
                    uploadAudioFile(audioFile);
                };

                mediaRecorder.start();
                button.textContent = 'Остановить запись';
                isRecording = true;
            })
            .catch(error => {
                console.error('Ошибка доступа к микрофону:', error);
            });
    } else {
        // Остановка записи
        mediaRecorder.stop();
        button.textContent = 'Начать запись';
        isRecording = false;
    }
});


function uploadAudioFile(audioFile) {
    const formData = new FormData();
    formData.append('audio_file', audioFile, audioFile.name);
    formData.append('action', 'upload_audio_to_wordpress'); // Для обработки на сервере WordPress

    // Сначала отправляем файл на WordPress сервер
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Файл успешно загружен на WordPress:', data);
                console.log('Отправляемый URL:', data.data?.url);

                const formData = new FormData();
                formData.append('url', data.data?.url);

                fetch('https://free-bobcats-cheat.loca.lt/upload-audio/', {
                    method: 'POST',
                    body: formData
                })
                    .then(apiResponse => apiResponse.json())
                    .then(apiData => {
                        console.log('API вернул результат анализа:', apiData);

                        const chords = apiData.chords && Array.isArray(apiData.chords)
                            ? apiData.chords.map(chord => chord.chord).join(', ') // Извлекаем свойство 'chord'
                            : 'Нет данных';

                        // Обновляем UI на основе возвращенных данных
                        document.getElementById('response').innerHTML = `
        <p>Анализ завершен:</p>
        <p>Аккорды: ${chords}</p>
    `;
                    })
                    .catch(apiError => {
                        console.error('Ошибка при отправке запроса к API:', apiError);
                        document.getElementById('response').textContent = 'Ошибка при анализе файла на API.';
                    });
            } else {
                console.error('Ошибка при загрузке файла на WordPress:', data.data);
                document.getElementById('response').textContent = `Ошибка загрузки файла: ${data.data}`;
            }
        })
        .catch(error => {
            console.error('Ошибка при отправке запроса на WordPress:', error);
            document.getElementById('response').textContent = `Ошибка при отправке запроса: ${error.message}`;
        });
}
