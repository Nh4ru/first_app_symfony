import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/pagination';

const swiper = new Swiper('.swiper-image', {
    direction: 'horizontal',
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: true,
    },
    grabCursor: true,
    pagination: {
        el: '.swiper-pagination'
    }
});
