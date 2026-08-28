import { onMounted, onUnmounted } from 'vue'

export function useEmberParticles(canvasRef) {
  let width = 0
  let height = 0
  let particles = []
  let animationFrameId = null
  let resizeObserver = null

  function resize() {
    const canvas = canvasRef.value
    if (!canvas) return
    width = canvas.width = canvas.offsetWidth
    height = canvas.height = canvas.offsetHeight
  }

  function makeParticles() {
    const total = Math.min(34, Math.floor(width / 32))
    particles = Array.from({ length: total }, () => ({
      x: Math.random() * width,
      y: height + Math.random() * height * 0.5,
      r: 1 + Math.random() * 2.2,
      speed: 0.25 + Math.random() * 0.6,
      drift: (Math.random() - 0.5) * 0.4,
      alpha: 0.15 + Math.random() * 0.5,
      hue: Math.random() > 0.5 ? '255,207,77' : '255,90,31',
    }))
  }

  function tick() {
    const canvas = canvasRef.value
    if (!canvas) return
    const ctx = canvas.getContext('2d')
    ctx.clearRect(0, 0, width, height)
    particles.forEach((p) => {
      p.y -= p.speed
      p.x += p.drift
      if (p.y < -10) {
        p.y = height + 10
        p.x = Math.random() * width
      }
      ctx.beginPath()
      ctx.fillStyle = `rgba(${p.hue},${p.alpha})`
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2)
      ctx.fill()
    })
    animationFrameId = requestAnimationFrame(tick)
  }

  onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return
    if (!canvasRef.value) return

    resize()
    makeParticles()
    tick()

    resizeObserver = new ResizeObserver(() => resize())
    resizeObserver.observe(canvasRef.value)
  })

  onUnmounted(() => {
    if (animationFrameId) cancelAnimationFrame(animationFrameId)
    resizeObserver?.disconnect()
  })
}
