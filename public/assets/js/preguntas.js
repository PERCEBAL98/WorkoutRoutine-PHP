document.querySelectorAll('.faq-contenedor').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.faq-contenedor').forEach(i => {
      if (i !== item) i.classList.remove('active');
    });
    item.classList.toggle('active');
  });
});