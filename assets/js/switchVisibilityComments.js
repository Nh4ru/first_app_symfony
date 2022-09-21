import axios from 'axios';

const switchs = document.querySelectorAll('[data-switch-active-comment]');

if (switchs) {
    switchs.forEach((element) => {
        element.addEventListener('change', () => {
            let commentId = element.value;
            axios.get(`/admin/comments/switch/${commentId}`)
       })
    });
}