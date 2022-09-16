const navbar = document.querySelector('.navbar');

window.onscroll = () => {
        if (
            document.body.scrollTop > navbar.offsetHeight ||
            document.documentElement.scrollTop > navbar.offsetHeight
        ) {
            navbar.classList.add('fixed-top');
        } else {
            navbar.classList.remove('fixed-top');
        }
    }

    // window.onscroll = function () { scrollFunction() }

    // function scrollFunction() {
    //     if (
    //         document.body.scrollTop > navbar.offsetHeight ||
    //         document.documentElement.scrollTop > navbar.offsetHeight
    //     ) {
    //         navbar.classList.add('fixed-top');
    //     } else {
    //         navbar.classList.remove('fixed-top');
    //     }
    // }