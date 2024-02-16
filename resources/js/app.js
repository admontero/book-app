import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

document.addEventListener('alpine:init', () => {

    const darkModeIsValid = ['true', 'false'].includes(window.localStorage.getItem('isDarkModeOn'))

    if (! darkModeIsValid) window.localStorage.removeItem('isDarkModeOn')

    Alpine.store('darkMode', {
        on: Alpine.$persist(false).as('isDarkModeOn'),

        toggle() {
            this.on = ! this.on
            this.switch()
        },

        switch() {
            this.on
                ? document.documentElement.classList.add('dark')
                : document.documentElement.classList.remove('dark')
        }
    })

    const sidebarIsValid = ['true', 'false'].includes(window.localStorage.getItem('extendedSidebar'))

    if (! sidebarIsValid) window.localStorage.removeItem('extendedSidebar')

    Alpine.store('sidebar', {
        on: Alpine.$persist(true).as('extendedSidebar'),

        toggle() {
            this.on = ! this.on
        }
    })
})

Livewire.start()
