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
  const socialDefs=[
    ['Instagram','IG','instagram','a[href*="instagram.com"]','https://www.instagram.com/'],
    ['Facebook','f','facebook','a[href*="facebook.com"]','https://www.facebook.com/'],
    ['X / Twitter','X','twitter','a[href*="twitter.com"],a[href*="x.com"]','https://x.com/'],
    ['YouTube','▶','youtube','a[href*="youtube.com"],a[href*="youtu.be"]','https://www.youtube.com/']
  ];
  const found=socialDefs.map(([label,short,cls,selector,fallback])=>{
    const el=document.querySelector(selector);
    return {label,short,cls,url:el?.href||fallback};
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
      found.map(s=>'<a class="is-'+s.cls+'" href="'+s.url+'" target="_blank" rel="noopener"><b>'+s.short+'</b><span>'+s.label+'</span></a>').join('')+
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
