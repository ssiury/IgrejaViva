const prefersReducedMotion = () =>
  window.matchMedia('(prefers-reduced-motion: reduce)').matches

const observer =
  typeof IntersectionObserver === 'undefined'
    ? null
    : new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('in')
              observer.unobserve(entry.target)
            }
          })
        },
        { threshold: 0.12 },
      )

export const vReveal = {
  mounted(el) {
    el.classList.add('reveal')

    if (prefersReducedMotion() || !observer) {
      el.classList.add('in')
      return
    }

    observer.observe(el)
  },
  unmounted(el) {
    observer?.unobserve(el)
  },
}
