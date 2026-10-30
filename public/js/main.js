(() => {
  const menu = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav');
  if (menu && nav) {
    const close = () => { nav.classList.remove('open'); menu.setAttribute('aria-expanded','false'); };
    menu.addEventListener('click', () => {
      const next = menu.getAttribute('aria-expanded') !== 'true';
      menu.setAttribute('aria-expanded', String(next));
      nav.classList.toggle('open', next);
    });
    nav.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
    window.addEventListener('keydown', e => { if(e.key === 'Escape') close(); });
  }

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const els = document.querySelectorAll('.reveal');
  if(!reduced && 'IntersectionObserver' in window){
    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if(entry.isIntersecting){ entry.target.classList.add('show'); io.unobserve(entry.target); }
      });
    }, { threshold:.08 });
    els.forEach(el => io.observe(el));
  } else {
    els.forEach(el => el.classList.add('show'));
  }

  const canvas = document.getElementById('motion-canvas');
  if(!canvas) return;
  const ctx = canvas.getContext('2d');
  if(!ctx) return;
  let w=0,h=0,dpr=1;
  const resize = () => {
    dpr = Math.min(window.devicePixelRatio || 1, 1.5);
    w = window.innerWidth; h = window.innerHeight;
    canvas.width = Math.round(w*dpr); canvas.height = Math.round(h*dpr);
    ctx.setTransform(dpr,0,0,dpr,0,0);
  };
  resize(); window.addEventListener('resize', resize, { passive:true });
  function draw(t){
    ctx.clearRect(0,0,w,h);
    const time=t*0.001;
    const grad=ctx.createRadialGradient(w*.5,h*.38,0,w*.5,h*.38,Math.max(w,h)*.52);
    grad.addColorStop(0,'rgba(5,147,198,.20)');
    grad.addColorStop(.42,'rgba(216,57,149,.13)');
    grad.addColorStop(1,'rgba(0,0,0,0)');
    ctx.fillStyle=grad; ctx.fillRect(0,0,w,h);

    const wave = new Path2D();
    const amp = Math.min(38, h*0.06);
    const base = h*0.57 + Math.sin(time*0.7)*16;
    for(let x=0; x<=w+10; x+=10){
      const y = base + Math.sin((x/w)*Math.PI*2 + time*1.2)*amp + Math.sin((x/w)*Math.PI*4 - time*0.7)*(amp*0.36);
      if(x===0) wave.moveTo(x,y); else wave.lineTo(x,y);
    }
    ctx.lineWidth = 110; ctx.lineCap='round';
    ctx.filter = 'blur(55px)'; ctx.strokeStyle='rgba(5,147,198,.17)'; ctx.stroke(wave);
    ctx.lineWidth = 60; ctx.strokeStyle='rgba(216,57,149,.12)'; ctx.stroke(wave);
    ctx.filter='none';
    ctx.lineWidth = 1.6; ctx.strokeStyle='rgba(255,255,255,.16)'; ctx.stroke(wave);
  }
  if(reduced){ draw(0); return; }
  let raf=0;
  const loop = (t) => { draw(t); raf=requestAnimationFrame(loop); };
  raf=requestAnimationFrame(loop);
  document.addEventListener('visibilitychange',()=>{
    if(document.hidden) cancelAnimationFrame(raf); else raf=requestAnimationFrame(loop);
  });
})();
