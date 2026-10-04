const menuBtn=document.querySelector('.home-menu-btn');
const menu=document.querySelector('.home-menu');

if(menuBtn&&menu){
  menuBtn.addEventListener('click',()=>{
    const open=menu.classList.toggle('open');
    menuBtn.setAttribute('aria-expanded',String(open));
  });
  menu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{
    menu.classList.remove('open');
    menuBtn.setAttribute('aria-expanded','false');
  }));
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
    const url='https://wa.me/905000000000?text='+encodeURIComponent(lines.join('\n'));
    const note=form.querySelector('[data-form-note]');
    if(note) note.textContent='WhatsApp mesajınız hazırlanıyor...';
    window.open(url,'_blank','noopener');
  });
}