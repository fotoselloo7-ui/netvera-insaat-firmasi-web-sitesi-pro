const menuBtn=document.querySelector('.home-menu-btn');
const menu=document.querySelector('.home-menu');

if(menuBtn&&menu){
  const closeMenu=()=>{
    menu.classList.remove('open');
    menuBtn.setAttribute('aria-expanded','false');
  };
  menuBtn.setAttribute('aria-expanded','false');
  menuBtn.addEventListener('click',e=>{
    e.stopPropagation();
    const open=menu.classList.toggle('open');
    menuBtn.setAttribute('aria-expanded',String(open));
  });
  menu.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
  document.addEventListener('click',e=>{
    if(menu.classList.contains('open')&&!menu.contains(e.target)&&!menuBtn.contains(e.target)) closeMenu();
  });
  document.addEventListener('keydown',e=>{
    if(e.key==='Escape') closeMenu();
  });
  window.addEventListener('resize',()=>{
    if(window.innerWidth>980) closeMenu();
  },{passive:true});
}

document.querySelectorAll('[data-year]').forEach(e=>e.textContent=new Date().getFullYear());

const form=document.querySelector('[data-home-form]');
if(form){
  form.addEventListener('submit',e=>{
    e.preventDefault();
    const data=new FormData(form);
    const name=(data.get('name')||'').toString().trim();
    const phone=(data.get('phone')||'').toString().trim();
    const type=(data.get('type')||'').toString().trim();
    const location=(data.get('location')||'').toString().trim();
    const message=(data.get('message')||'').toString().trim();
    const lines=[
      'Merhaba Vera Yapı, web sitenizden teklif talebi oluşturuyorum.',
      '',
      'Ad Soyad: '+name,
      'Telefon: '+phone,
      'Proje Türü: '+type,
      'Konum: '+(location||'-'),
      'Proje Bilgisi: '+(message||'-')
    ];
    const whatsapp=(form.dataset.whatsapp||'905000000000').replace(/\D/g,'');
    const url='https://wa.me/'+whatsapp+'?text='+encodeURIComponent(lines.join('\n'));
    const note=form.querySelector('[data-form-note]');
    if(note) note.textContent='WhatsApp mesajınız hazırlanıyor...';
    window.open(url,'_blank','noopener');
  });
}

const slider=document.querySelector('[data-slider]');
if(slider){
  const slides=[...slider.querySelectorAll('.home-slide')];
  const dots=[...document.querySelectorAll('[data-slide-to]')];
  const prev=document.querySelector('[data-slide-prev]');
  const next=document.querySelector('[data-slide-next]');
  let index=0;
  let timer=null;

  const show=i=>{
    index=(i+slides.length)%slides.length;
    slides.forEach((slide,n)=>slide.classList.toggle('is-active',n===index));
    dots.forEach((dot,n)=>dot.classList.toggle('is-active',n===index));
  };
  const start=()=>{
    clearInterval(timer);
    timer=setInterval(()=>show(index+1),6500);
  };
  dots.forEach((dot,n)=>dot.addEventListener('click',()=>{show(n);start()}));
  if(prev)prev.addEventListener('click',()=>{show(index-1);start()});
  if(next)next.addEventListener('click',()=>{show(index+1);start()});
  slider.addEventListener('mouseenter',()=>clearInterval(timer));
  slider.addEventListener('mouseleave',start);
  let touchStart=0;
  slider.addEventListener('touchstart',e=>{touchStart=e.changedTouches[0].clientX},{passive:true});
  slider.addEventListener('touchend',e=>{
    const delta=e.changedTouches[0].clientX-touchStart;
    if(Math.abs(delta)>45){show(index+(delta<0?1:-1));start()}
  },{passive:true});
  show(0);
  start();
}


/* premium motion */
const header=document.querySelector('.home-header');
if(header){
  const syncHeader=()=>header.classList.toggle('is-scrolled',window.scrollY>18);
  syncHeader();
  window.addEventListener('scroll',syncHeader,{passive:true});
}

if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window){
  const revealTargets=document.querySelectorAll(
    '.home-section-head-v5,.home-section-head-v6,.about-editorial-media,.about-editorial-copy,.about-principle,.services-head-v7,.service-card-v7,.home-cta-line-inner,.project-featured-v5,.project-side-v5,.why-editorial-media,.why-editorial-copy,.why-row-v5,.process-card-v6,.testimonial-card-v7,.testimonial-card-v8,.trust-panel-v6,.region-panel-v6,.insight-featured,.insight-side,.faq-v5 details,.contact-panel-v5,.page-hero-modern .container,.list-card,.detail-hero-grid,.content-prose,.detail-aside,.editorial-intro,.fact-ribbon,.principle-card,.service-directory-row,.project-featured-card,.project-case-card,.project-detail-head,.project-detail-cover,.project-facts,.case-story,.blog-lead-card,.blog-side-card,.article-hero-inner,.article-cover,.article-body,.article-author,.contact-panel,.contact-form-shell,.contact-expectation>div,.scope-card,.related-project-card,.region-card'
  );
  revealTargets.forEach((el,index)=>{
    el.classList.add('reveal-ready');
    const parent=el.parentElement;
    if(parent){
      const siblings=[...parent.children].filter(node=>node.matches?.('.service-card-v7,.process-card-v6,.project-side-v5,.insight-side,.faq-v5 details,.trust-panel-v6,.region-panel-v6'));
      const localIndex=siblings.indexOf(el);
      if(localIndex>=0) el.style.setProperty('--reveal-delay',Math.min(localIndex,5)*55+'ms');
    }
  });
  const revealObserver=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){
        entry.target.classList.add('reveal-in');
        revealObserver.unobserve(entry.target);
      }
    });
  },{threshold:.12,rootMargin:'0px 0px -35px'});
  revealTargets.forEach(el=>revealObserver.observe(el));
}
