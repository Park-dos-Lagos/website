
function toggleReadMore(button) {
  const content = button.previousElementSibling;
  const isHidden = content.style.display === 'none' || content.style.display === '';

  content.style.display = isHidden ? 'block' : 'none';
  button.textContent = isHidden ? 'Leia menos' : 'Leia mais';
}
