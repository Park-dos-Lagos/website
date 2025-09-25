function toggleReadMore(button) {
  const wrapper = button.closest('.read-more-wrapper');
  const content = wrapper.querySelector('.read-more-content');

  const isHidden = content.style.display === 'none' || content.style.display === '';
  content.style.display = isHidden ? 'block' : 'none';
  button.textContent = isHidden ? 'Leia menos' : 'Leia mais';
}
