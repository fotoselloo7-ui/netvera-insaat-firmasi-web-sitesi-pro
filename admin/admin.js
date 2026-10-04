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