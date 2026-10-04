const body=document.body;
const openBtn=document.querySelector('[data-sidebar-open]');
const closeBtn=document.querySelector('[data-sidebar-close]');
const backdrop=document.querySelector('[data-sidebar-backdrop]');

const closeSidebar=()=>body.classList.remove('sidebar-open');
if(openBtn) openBtn.addEventListener('click',()=>body.classList.add('sidebar-open'));
if(closeBtn) closeBtn.addEventListener('click',closeSidebar);
if(backdrop) backdrop.addEventListener('click',closeSidebar);
document.addEventListener('keydown',e=>{if(e.key==='Escape') closeSidebar()});

const passwordToggle=document.querySelector('[data-password-toggle]');
const passwordInput=document.querySelector('#admin-password');
if(passwordToggle&&passwordInput){
  passwordToggle.addEventListener('click',()=>{
    const show=passwordInput.type==='password';
    passwordInput.type=show?'text':'password';
    passwordToggle.textContent=show?'Gizle':'Göster';
    passwordToggle.setAttribute('aria-label',show?'Şifreyi gizle':'Şifreyi göster');
  });
}

document.querySelectorAll('input[type="file"]').forEach(input=>{
  input.addEventListener('change',()=>{
    const field=input.closest('.admin-field');
    if(!field) return;
    const small=field.querySelector('small');
    if(small && input.files && input.files[0]){
      small.textContent='Seçilen dosya: '+input.files[0].name;
    }
  });
});

/* SEO live preview + readiness */
document.querySelectorAll('.seo-fieldset').forEach(fieldset=>{
  const form=fieldset.closest('form');
  if(!form) return;

  const value=name=>{
    const el=form.querySelector('[name="'+name+'"]');
    return el ? String(el.value||'').trim() : '';
  };

  const preview=fieldset.querySelector('[data-seo-preview]');
  const scoreBox=fieldset.querySelector('[data-seo-live-score] strong');

  const updatePreview=()=>{
    if(preview){
      const title=value('meta_title')||value('title')||'SEO başlığınız burada görünecek';
      const description=value('meta_description')||value('summary')||value('excerpt')||value('intro')||'Meta açıklamanız burada önizlenir.';
      const canonical=value('canonical_url');
      const slug=value('slug');
      const base=preview.dataset.previewBase||'';
      const url=canonical || (base + slug);

      const titleEl=preview.querySelector('[data-preview-title]');
      const descEl=preview.querySelector('[data-preview-description]');
      const urlEl=preview.querySelector('[data-preview-url]');
      if(titleEl) titleEl.textContent=title;
      if(descEl) descEl.textContent=description;
      if(urlEl) urlEl.textContent=url;
    }

    const checks=[
      !!value('meta_title'),
      !!value('meta_description'),
      !!value('focus_keyword'),
      !!value('secondary_keywords'),
      !!value('canonical_url') || !!value('slug'),
      !!value('image_alt'),
      !!value('og_image') || !!value('cover_image') || !!value('hero_image'),
      !!value('aio_summary'),
      !!value('robots'),
      !!value('schema_type')
    ];
    const score=Math.round(checks.filter(Boolean).length/checks.length*100);
    if(scoreBox) scoreBox.textContent=score+'%';
  };

  ['meta_title','meta_description','focus_keyword','secondary_keywords','canonical_url','slug','title','summary','excerpt','intro','image_alt','og_image','cover_image','hero_image','aio_summary','robots','schema_type']
    .forEach(name=>{
      const el=form.querySelector('[name="'+name+'"]');
      if(el){
        el.addEventListener('input',updatePreview);
        el.addEventListener('change',updatePreview);
      }
    });

  ['meta_title','meta_description','og_title','og_description'].forEach(name=>{
    const el=form.querySelector('[name="'+name+'"]');
    if(!el) return;
    const field=el.closest('.admin-field');
    if(!field) return;
    let counter=field.querySelector('.seo-char-count');
    if(!counter){
      counter=document.createElement('span');
      counter.className='seo-char-count';
      field.appendChild(counter);
    }
    const sync=()=>counter.textContent=el.value.length+' karakter';
    el.addEventListener('input',sync);
    sync();
  });

  updatePreview();
});
