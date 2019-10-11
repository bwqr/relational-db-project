import Vue from 'vue'
import {MDCTopAppBar} from "@material/top-app-bar";
import {MDCDrawer} from "@material/drawer";
import {MDCSelect} from '@material/select';
import {MDCTextField} from '@material/textfield';
import {MDCRipple} from '@material/ripple';
import {MDCCheckbox} from '@material/checkbox';

Vue.component('app-home', require('./components/app.vue').default);

window.Vue = Vue;

var app = new Vue({
    el: '#app',
    data: {
        role: ''
    },
    methods: {
        getRole: () => localStorage.getItem('role') || 'user',
        setRole: function(event) {
            localStorage.setItem('role', this.role);
        },
    },
    mounted() {
        this.role = localStorage.getItem('role');
    }
});

const drawers = document.querySelector('.mdc-drawer');

if(drawers) {
    const drawer = MDCDrawer.attachTo(drawers);
    const topbars = document.getElementById('app-bar');

    if(topbars) {
        const topAppBar = MDCTopAppBar.attachTo(topbars);
        topAppBar.setScrollTarget(document.getElementById('main-content'));
        topAppBar.listen('MDCTopAppBar:nav', () => {
            drawer.open = !drawer.open;
        });
    }
}

const textFields = document.querySelectorAll('.mdc-text-field');
textFields.forEach((el) => new MDCTextField(el));

const selects = document.querySelectorAll('.mdc-select');
selects.forEach((el) => new MDCSelect(el));

const ripples = document.querySelectorAll('.mdc-button');
ripples.forEach((el) => new MDCRipple(el));

const fabRipples = document.querySelectorAll('.mdc-fab');
fabRipples.forEach((el) => new MDCRipple(el));

const checkboxes = document.querySelectorAll('.mdc-checkbox');
checkboxes.forEach((el) => {
    const checkBox = new MDCCheckbox(el);
    if(el.firstChild.getAttribute('value') === "1") {
        checkBox.checked = true;
    }
});
