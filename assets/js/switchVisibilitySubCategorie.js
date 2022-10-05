import axios from 'axios';

let switchs = document.querySelectorAll('[data-switch-active-subTag]');

if (switchs) {
    switchs.forEach((element) => {
        element.addEventListener('change', () => {
            let tagId = element.value;
            axios.get(`/admin/categorie/sub_categorie/switch/${tagId}`)
        });
    });
}