import Alpine from 'alpinejs'
window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', (slides) => ({
        slides: slides ?? [],

        current: 0,
        contentVisible: true,
        paused: false,
        _timer: null,

        init() {
            if (this.slides.length < 2) return
            this._timer = setInterval(() => {
                if (!this.paused) this.next()
            }, 5500)
        },

        go(i) {
            if (i === this.current) return
            this.contentVisible = false
            setTimeout(() => {
                this.current = i
                this.contentVisible = true
            }, 350)
        },

        next() { this.go((this.current + 1) % this.slides.length) },
        prev() { this.go((this.current - 1 + this.slides.length) % this.slides.length) },
    }))

    Alpine.data('announcementPopup', (id) => ({
        id: id,
        show: false,

        init() {
            try {
                this.show = localStorage.getItem('fmks_announcement_dismissed') !== String(this.id)
            } catch (e) {
                this.show = true
            }
        },

        dismiss() {
            try {
                localStorage.setItem('fmks_announcement_dismissed', String(this.id))
            } catch (e) {
                // ignore (private browsing, storage disabled, etc.)
            }
            this.show = false
        },
    }))
})

Alpine.start()
