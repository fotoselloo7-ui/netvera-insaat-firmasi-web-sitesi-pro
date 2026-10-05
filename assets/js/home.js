/* static-preview brand mark normalization */
document.querySelectorAll('.home-logo-mark').forEach(mark=>{
  if(mark.querySelector('img')) return;
  const img=document.createElement('img');
  img.src='assets/brand/netvera-mark.svg';
  img.alt='NetVera';
  img.width=44;
  img.height=44;
  img.style.cssText='width:100%;height:100%;object-fit:contain;display:block';
  mark.textContent='';
  mark.appendChild(img);
  mark.classList.add('has-brand-image');
});

const menuBtn=document.querySelector('.home-menu-btn');
const menu=document.querySelector('.home-menu');


/* static-preview mobile menu fallback: PHP header already renders this on production */
if(menu && !menu.querySelector('.home-menu-mobile-extra')){
  const phoneHref=document.querySelector('.home-mobile-phone')?.getAttribute('href')||'tel:+905000000000';
  const waHref=document.querySelector('.home-mobile-wa')?.getAttribute('href')||'https://wa.me/905000000000';
  if(!menu.querySelector('.home-nav-cta')){
    const cta=document.createElement('a');
    cta.className='home-nav-cta';
    cta.href='iletisim.html';
    cta.textContent='Ücretsiz Keşif Talebi';
    menu.appendChild(cta);
  }
  const icons={
    instagram:'<svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.25" y="3.25" width="17.5" height="17.5" rx="5" fill="none" stroke="currentColor" stroke-width="1.9"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.9"/><circle cx="17.45" cy="6.65" r="1.05" fill="currentColor"/></svg>',
    facebook:'<svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.7 21v-8h2.8l.45-3.15H13.7V7.82c0-.91.28-1.53 1.62-1.53H17V3.48c-.29-.04-1.29-.13-2.46-.13-2.44 0-4.11 1.49-4.11 4.22v2.28H7.67V13h2.76v8h3.27Z"/></svg>',
    linkedin:'<svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2.6" fill="currentColor"/><circle cx="8" cy="9" r="1.35" fill="#fff"/><rect x="6.8" y="11" width="2.4" height="6.2" fill="#fff"/><path d="M11 11h2.3v.85c.62-.75 1.48-1.15 2.55-1.15 2.13 0 3.35 1.35 3.35 3.82v2.68h-2.4v-2.52c0-1.21-.42-1.95-1.52-1.95-1.22 0-1.88.83-1.88 2.28v2.19H11V11Z" fill="#fff"/></svg>',
    twitter:'<svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4.5 19 19.5M19 4.5 5 19.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>',
    youtube:'<svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="2.5" y="6" width="19" height="12" rx="4" fill="currentColor"/><path d="m10 9 5 3-5 3V9Z" fill="#fff"/></svg>'
  };
  const socialDefs=[
    ['Instagram','instagram','a[href*="instagram.com"]','https://www.instagram.com/'],
    ['Facebook','facebook','a[href*="facebook.com"]','https://www.facebook.com/'],
    ['LinkedIn','linkedin','a[href*="linkedin.com"]','https://www.linkedin.com/'],
    ['X / Twitter','twitter','a[href*="twitter.com"],a[href*="x.com"]','https://x.com/'],
    ['YouTube','youtube','a[href*="youtube.com"],a[href*="youtu.be"]','https://www.youtube.com/']
  ];
  const found=socialDefs.map(([label,cls,selector,fallback])=>{
    const el=document.querySelector(selector);
    return {label,cls,icon:icons[cls],url:el?.href||fallback};
  });
  const extra=document.createElement('div');
  extra.className='home-menu-mobile-extra';
  extra.innerHTML=
    '<div class="home-menu-mobile-label">Hızlı İletişim</div>'+
    '<div class="home-menu-mobile-contact">'+
      (phoneHref?'<a href="'+phoneHref+'"><span>☎</span>Ara</a>':'')+
      (waHref?'<a class="is-wa" href="'+waHref+'" target="_blank" rel="noopener"><span>◉</span>WhatsApp</a>':'')+
    '</div>'+
    (found.length?'<div class="home-menu-mobile-label">Sosyal Medya</div><div class="home-menu-mobile-socials">'+
      found.map(s=>'<a class="is-'+s.cls+'" href="'+s.url+'" target="_blank" rel="noopener"><b>'+s.icon+'</b><span>'+s.label+'</span></a>').join('')+
    '</div>':'');
  menu.appendChild(extra);
}

if(menuBtn&&menu){
  const backdrop=document.createElement('button');
  backdrop.type='button';
  backdrop.className='home-menu-backdrop';
  backdrop.setAttribute('aria-label','Menüyü kapat');
  document.body.appendChild(backdrop);

  const syncMenuState=open=>{
    menu.classList.toggle('open',open);
    document.body.classList.toggle('menu-open',open);
    menuBtn.setAttribute('aria-expanded',String(open));
    menuBtn.setAttribute('aria-label',open?'Menüyü kapat':'Menüyü aç');
    menuBtn.classList.toggle('is-open',open);
  };
  const closeMenu=()=>syncMenuState(false);
  menuBtn.setAttribute('aria-expanded','false');
  menuBtn.addEventListener('click',e=>{
    e.stopPropagation();
    syncMenuState(!menu.classList.contains('open'));
  });
  menu.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
  backdrop.addEventListener('click',closeMenu);
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
      'Merhaba '+((form.dataset.siteName||document.querySelector('.home-logo>span:last-child')?.firstChild?.textContent||'').trim()||'Vera Yapı')+', web sitenizden teklif talebi oluşturuyorum.',
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
    '.home-section-head-v5,.home-section-head-v6,.about-editorial-media,.about-editorial-copy,.about-principle,.services-head-v7,.service-card-v7,.home-cta-line-inner,.project-featured-v5,.project-side-v5,.why-editorial-media,.why-editorial-copy,.why-row-v5,.process-card-v6,.testimonial-card-v7,.testimonial-card-v8,.trust-panel-v6,.region-panel-v6,.insight-featured,.insight-side,.faq-v5 details,.contact-panel-v5,.page-hero-modern .container,.page-title-row,.inline-editorial-cta,.list-card,.detail-hero-grid,.content-prose,.detail-aside,.editorial-intro,.fact-ribbon,.principle-card,.process-step,.service-directory-row,.service-proof,.project-featured-card,.project-case-card,.project-detail-head,.project-detail-cover,.project-facts,.case-story,.project-gallery-wide img,.blog-editorial-grid,.blog-lead-card,.blog-side-card,.article-hero-inner,.article-cover,.article-body,.article-author,.article-related .list-card,.contact-panel,.contact-form-shell,.contact-social-btn,.contact-map-head,.contact-map-frame,.contact-expectation>div,.service-method-card,.scope-card,.related-project-card,.region-card'
  );
  revealTargets.forEach((el,index)=>{
    el.classList.add('reveal-ready');
    const parent=el.parentElement;
    if(parent){
      const siblings=[...parent.children].filter(node=>node.matches?.('.service-card-v7,.process-card-v6,.process-step,.service-directory-row,.service-method-card,.principle-card,.scope-card,.project-case-card,.related-project-card,.blog-side-card,.list-card,.region-card,.contact-expectation>div,.project-side-v5,.insight-side,.faq-v5 details,.trust-panel-v6,.region-panel-v6'));
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


/* touch interaction parity: mirrors desktop hover language without sticky :hover */
if(window.matchMedia('(hover: none), (pointer: coarse)').matches){
  const touchTargets=document.querySelectorAll(
    '.home-btn,.home-nav-cta,.micro-link-v6,.text-link-v5,.service-card-v7,.project-featured-v5,.project-side-v5,.process-card-v6,.testimonial-card-v8,.trust-list-v6>div,.region-links-v6 a,.about-principle,.why-row-v5,.insight-side,.quick-cta,.contact-panel-v5,.principle-card,.process-step,.scope-card,.project-case-card,.related-project-card,.blog-side-card,.list-card,.region-card,.contact-expectation>div,.service-method-card,.service-directory-row,.project-facts>div,.fact-ribbon>div,.contact-channel'
  );
  const clear=el=>{
    el.classList.remove('is-touch-active');
    if(el._touchTimer){clearTimeout(el._touchTimer);el._touchTimer=null}
  };
  touchTargets.forEach(el=>{
    el.addEventListener('pointerdown',()=>{
      clear(el);
      el.classList.add('is-touch-active');
    },{passive:true});
    ['pointerup','pointercancel','pointerleave'].forEach(evt=>el.addEventListener(evt,()=>{
      el._touchTimer=setTimeout(()=>clear(el),120);
    },{passive:true}));
  });
  window.addEventListener('scroll',()=>touchTargets.forEach(clear),{passive:true});
}
