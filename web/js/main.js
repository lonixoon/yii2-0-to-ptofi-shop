/*price range*/

$('#sl2').slider();

$('.catalog').dcAccordion({
    speed: 300
});

// показывае модальное окно и передаём в него html из фукции добавляения товара в корзину
function showCart(cart) {
    $('#cart .modal-body').html(cart);
    $('#cart').modal();
}

// показывает содержимое корзины
function getCart(){
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });
    return false;
}

// очищает корзину, запуская метод clear
function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (res) {
            // если ответа нет, выводим ошибку
            if (!res) alert('Ошибка!');
            // если ответ есть, вставляем его в функцию вывода модального окна
            showCart(res);
        },
        error: function () {
            alert('Error!');
        }
    });
}

// Удаляем товар из корзины
// Делигируем события т.к. элемента .modal-body пока мы его не вызовем ещё нет.
$('#cart .modal-body').on('click', '.del-item', function(){

    var id = $(this).data('id');
    $.ajax({
        url: '/cart/del-item',
        // получаем id товара из data-id
        data: {id: id},
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });
});

// добавляем товар в карзину
$('.add-to-cart').on('click', function (e) {
    e.preventDefault();
    // получаем id товара из data-id
    var id = $(this).data('id');

    $.ajax({
        //отправляем запрос на контроллер
        url: '/cart/add',
        // передаём id товара
        data: {id: id},
        type: 'GET',
        success: function (res) {
            // если ответа нет, выводим ошибку
            if (!res) alert('Ошибка!');
            // если ответ есть, вставляем его в функцию вывода модального окна
            showCart(res);
        },
        error: function () {
            alert('Error!');
        }
    });
});

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});
