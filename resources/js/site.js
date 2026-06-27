import Alpine from 'alpinejs'
window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', () => ({
        slides: [
            {
                image: '/images/slides/slide-1.webp',
                tag: 'Welcome to FMKS',
                headline: 'Excellence in<br/>Education',
                sub: 'Nurturing brilliant minds through academic excellence, strong values, and holistic development — from Crèche through to Senior Secondary.',
                cta1: { text: 'Apply for 2025/2026', href: '/admissions/apply' },
                cta2: { text: 'Discover Our School', href: '#about' },
            },
            {
                image: '/images/slides/slide-2.webp',
                tag: 'Academic Excellence',
                headline: 'Shaping Leaders,<br/>Lighting Futures',
                sub: 'Award-winning results, dedicated teachers, and a curriculum designed to prepare your child for a lifetime of impact.',
                cta1: { text: 'Our Programmes', href: '/academics' },
                cta2: { text: 'View Achievements', href: '/student-life/achievements' },
            },
            {
                image: '/images/slides/slide-3.webp',
                tag: 'Admissions Open',
                headline: 'Your Child\'s Journey<br/>Begins Here',
                sub: 'Applications are open for the 2025/2026 academic session. Join the FMKS family and give your child the future they deserve.',
                cta1: { text: 'Apply Now', href: '/admissions/apply' },
                cta2: { text: 'Admissions Info', href: '/admissions' },
            },
        ],

        current: 0,
        contentVisible: true,
        paused: false,
        _timer: null,

        init() {
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
})

Alpine.start()
